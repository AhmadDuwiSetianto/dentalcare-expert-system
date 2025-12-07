<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class DiagnosisController extends Controller
{
    public function index()
    {
        return view('diagnosis.index');
    }

    public function loadTab($tab)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            switch ($tab) {
                case 'start':
                    return $this->loadStartTab();
                case 'result':
                    return $this->loadResultTab();
                case 'history':
                    return $this->loadHistoryTab();
                case 'information':
                    return $this->loadInformationTab();
                default:
                    return response()->json(['success' => false, 'message' => 'Tab tidak ditemukan'], 404);
            }
        } catch (Exception $e) {
            Log::error('Error loading tab: ' . $e->getMessage());
            return "<div class='text-center py-8 text-red-400'>Error: " . $e->getMessage() . "</div>";
        }
    }

    private function loadStartTab()
    {
        $questions = Symptom::where('is_active', true)->orderBy('order')->get();
        if ($questions->isEmpty()) {
            return "<div class='text-center py-8 text-yellow-400'>Tidak ada pertanyaan tersedia. Hubungi admin.</div>";
        }
        return view('diagnosis.start')->render();
    }

    private function loadResultTab()
    {
        $latestDiagnosis = Diagnosis::where('user_id', Auth::id())->latest()->first();
        return view('diagnosis.result', compact('latestDiagnosis'))->render();
    }

    private function loadHistoryTab()
    {
        $diagnoses = Diagnosis::where('user_id', Auth::id())->latest()->limit(10)->get();
        return view('diagnosis.history', compact('diagnoses'))->render();
    }

    private function loadInformationTab()
    {
        $diseases = Disease::with('symptoms')->get();
        return view('diagnosis.information', compact('diseases'))->render();
    }

    // =========================================================================
    // CORE DIAGNOSIS LOGIC STARTS HERE
    // =========================================================================

    public function getQuestion(Request $request)
    {
        try {
            $step = (int) $request->input('step', 1);
            $answers = $request->input('answers', []);

            // Ambil semua gejala aktif
            $questions = Symptom::where('is_active', true)->orderBy('order')->get();
            $totalQuestions = $questions->count();

            // Jika langkah melebihi jumlah pertanyaan, hitung hasil
            if ($step > $totalQuestions) {
                return $this->finishDiagnosis($answers);
            }

            $currentQuestion = $questions[$step - 1];

            // Siapkan format response
            $questionData = [
                'id' => $currentQuestion->id,
                'code' => $currentQuestion->code,
                'text' => $currentQuestion->question,
                'type' => $currentQuestion->type,
                'options' => $currentQuestion->options ?? ['yes' => 'Ya', 'no' => 'Tidak']
            ];

            return response()->json([
                'success' => true,
                'question' => $questionData,
                'step' => $step,
                'total_questions' => $totalQuestions,
                'progress' => round(($step / $totalQuestions) * 100)
            ]);
        } catch (Exception $e) {
            Log::error('Get Question Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function processAnswer(Request $request)
    {
        try {
            $step = (int) $request->input('step', 1);
            $currentAnswer = $request->input('answer');
            $answers = $request->input('answers', []);
            
            // Validasi pertanyaan saat ini
            $currentQuestion = Symptom::where('is_active', true)
                                ->orderBy('order')
                                ->skip($step - 1)
                                ->first();

            if ($currentQuestion) {
                // Simpan jawaban dengan key q{ID}
                $answers['q' . $currentQuestion->id] = $currentAnswer;
            }

            $totalQuestions = Symptom::where('is_active', true)->count();
            $nextStep = $step + 1;

            // Cek apakah ini langkah terakhir
            if ($nextStep > $totalQuestions) {
                return $this->finishDiagnosis($answers);
            }

            // Load pertanyaan berikutnya
            $nextQuestion = Symptom::where('is_active', true)
                ->orderBy('order')
                ->skip($nextStep - 1)
                ->first();

            $questionData = [
                'id' => $nextQuestion->id,
                'code' => $nextQuestion->code,
                'text' => $nextQuestion->question,
                'type' => $nextQuestion->type,
                'options' => $nextQuestion->options ?? ['yes' => 'Ya', 'no' => 'Tidak']
            ];

            return response()->json([
                'success' => true,
                'question' => $questionData,
                'step' => $nextStep,
                'total_questions' => $totalQuestions,
                'progress' => round(($nextStep / $totalQuestions) * 100),
                'completed' => false
            ]);

        } catch (Exception $e) {
            Log::error('Process Answer Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function finishDiagnosis($answers)
    {
        $result = $this->runForwardChaining($answers);
        $diagnosis = $this->saveDiagnosis($result, $answers);

        return response()->json([
            'success' => true,
            'completed' => true,
            'result' => $result,
            'diagnosis_id' => $diagnosis ? $diagnosis->id : null
        ]);
    }

    /**
     * ALGORITMA FORWARD CHAINING DENGAN BOBOT (WEIGHTED)
     */
    private function runForwardChaining($answers)
    {
        Log::info('--- START DIAGNOSIS ---');
        Log::info('Raw Answers:', $answers);

        // 1. Parsing User Facts (Pastikan ID menjadi Integer)
        $userFacts = [];
        foreach ($answers as $key => $value) {
            // Hapus 'q' dan ambil ID
            if (str_starts_with($key, 'q')) {
                $id = (int) substr($key, 1);
                // Normalisasi jawaban 'yes'/'true'/'1' menjadi boolean true
                $isYes = in_array(strtolower($value), ['yes', 'ya', 'true', '1']);
                if ($isYes) {
                    $userFacts[$id] = true;
                }
            }
        }
        
        Log::info('Parsed User Facts (Positive Symptoms IDs):', array_keys($userFacts));

        // Jika tidak ada gejala positif, return default
        if (empty($userFacts)) {
            return $this->getDefaultDiagnosisResult();
        }

        // 2. Ambil Semua Penyakit dengan Gejala & Pivot Data (Bobot)
        $diseases = Disease::with(['symptoms'])->whereHas('symptoms')->get();
        $candidates = [];

        foreach ($diseases as $disease) {
            $totalWeight = 0;
            $matchedWeight = 0;
            $matchedCount = 0;

            foreach ($disease->symptoms as $symptom) {
                // Ambil bobot dari pivot table, default 1 jika null/0
                $weight = $symptom->pivot->weight > 0 ? $symptom->pivot->weight : 1;
                $totalWeight += $weight;

                // Cek apakah user mengalami gejala ini (ID match)
                if (isset($userFacts[$symptom->id])) {
                    $matchedWeight += $weight;
                    $matchedCount++;
                    Log::info("MATCH: Disease {$disease->name} - Symptom {$symptom->id} (Weight: $weight)");
                }
            }

            // Hitung Confidence
            // Rumus: (Total Bobot Cocok / Total Bobot Penyakit) * 100
            $confidence = 0;
            if ($totalWeight > 0) {
                $confidence = ($matchedWeight / $totalWeight) * 100;
            }

            Log::info("Disease: {$disease->name} | Match: $matchedCount | Score: $matchedWeight/$totalWeight | Confidence: $confidence%");

            if ($confidence > 0) {
                $candidates[] = [
                    'disease' => $disease,
                    'confidence' => $confidence,
                    'matched_count' => $matchedCount
                ];
            }
        }

        // 3. Ranking & Selection
        if (empty($candidates)) {
            return $this->getDefaultDiagnosisResult();
        }

        // Urutkan berdasarkan confidence tertinggi
        usort($candidates, function ($a, $b) {
            return $b['confidence'] <=> $a['confidence'];
        });

        $winner = $candidates[0];
        $disease = $winner['disease'];
        $finalConfidence = round($winner['confidence']);

        // Threshold minimal (Misal 20% agar tidak terlalu sensitif terhadap gejala umum)
        if ($finalConfidence < 20) {
            return $this->getDefaultDiagnosisResult();
        }

        return [
            'name' => $disease->name,
            'description' => $disease->description,
            'confidence' => $finalConfidence,
            'treatment' => $disease->treatment,
            'prevention' => $disease->prevention,
            'recommendation' => $this->generateRecommendation($finalConfidence, $disease->is_emergency),
            'is_emergency' => $disease->is_emergency,
            'severity' => $disease->severity ?? 'low',
            'matched_symptoms' => $winner['matched_count'],
            'total_symptoms' => $disease->symptoms->count(),
            'inference_method' => 'Weighted Forward Chaining'
        ];
    }

    private function saveDiagnosis($result, $answers)
    {
        try {
            return Diagnosis::create([
                'user_id' => Auth::id(),
                'disease_name' => $result['name'],
                'confidence_level' => $result['confidence'],
                'symptoms_checked' => json_encode($answers),
                'recommendation' => $result['recommendation'],
                'is_emergency' => $result['is_emergency'],
                'inference_method' => $result['inference_method'],
                'matched_symptoms_count' => $result['matched_symptoms'],
                'disease_description' => $result['description'],
                'treatment' => $result['treatment'],
                'prevention' => $result['prevention'],
                'severity' => $result['severity']
            ]);
        } catch (Exception $e) {
            Log::error('Save Diagnosis Error: ' . $e->getMessage());
            return null;
        }
    }

    private function generateRecommendation($confidence, $isEmergency)
    {
        if ($isEmergency) {
            return 'Kondisi DARURAT. Segera kunjungi rumah sakit atau dokter gigi sekarang juga.';
        }
        if ($confidence >= 80) {
            return 'Gejala sangat cocok. Disarankan segera konsultasi dokter untuk penanganan.';
        } elseif ($confidence >= 50) {
            return 'Ada indikasi penyakit ini. Periksakan diri ke dokter gigi untuk kepastian.';
        } else {
            return 'Gejala ringan terdeteksi. Jaga kebersihan mulut dan pantau perkembangannya.';
        }
    }

    private function getDefaultDiagnosisResult()
    {
        return [
            'name' => 'Tidak Terdeteksi',
            'description' => 'Sistem tidak menemukan kecocokan yang kuat dengan penyakit spesifik dalam database kami berdasarkan gejala yang Anda masukkan.',
            'confidence' => 0,
            'treatment' => 'Tetap jaga kebersihan mulut, sikat gigi 2 kali sehari, dan gunakan benang gigi.',
            'prevention' => 'Lakukan pemeriksaan rutin ke dokter gigi setiap 6 bulan sekali.',
            'recommendation' => 'Jika keluhan berlanjut, silakan konsultasi langsung dengan dokter gigi.',
            'is_emergency' => false,
            'severity' => 'low',
            'matched_symptoms' => 0,
            'total_symptoms' => 0,
            'inference_method' => 'Weighted Forward Chaining'
        ];
    }

    public function getDiagnosisDetail($id)
    {
        $diagnosis = Diagnosis::with('user')->findOrFail($id);
        if (Auth::id() != $diagnosis->user_id && !Auth::user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        return response()->json(['success' => true, 'diagnosis' => $diagnosis]);
    }

    public function downloadPDF($id)
    {
        try {
            $diagnosis = Diagnosis::with('user')->findOrFail($id);
            if (Auth::id() != $diagnosis->user_id && !Auth::user()->is_admin) {
                abort(403);
            }

            $pdf = Pdf::loadView('diagnosis.pdf', compact('diagnosis'));
            return $pdf->download('diagnosis-result-' . $diagnosis->id . '.pdf');
        } catch (Exception $e) {
            Log::error('PDF Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF');
        }
    }
}