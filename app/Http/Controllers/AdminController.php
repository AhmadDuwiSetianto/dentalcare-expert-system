<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Disease;
use App\Models\Symptom;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function loadTab($tab)
    {
        try {
            switch ($tab) {
                case 'dashboard':
                    return $this->loadDashboardTab();
                case 'users':
                    return $this->loadUsersTab();
                case 'diseases':
                    return $this->loadDiseasesTab();
                case 'symptoms':
                    return $this->loadSymptomsTab();
                case 'diagnoses':
                    return $this->loadDiagnosesTab();
                case 'settings':
                    return $this->loadSettingsTab();
                default:
                    return response()->json(['success' => false, 'message' => 'Tab tidak ditemukan'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memuat konten: ' . $e->getMessage()], 500);
        }
    }

    // ==================== LOAD TAB METHODS ====================
    private function loadDashboardTab()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'total_diagnoses' => Diagnosis::count(),
                'total_diseases' => Disease::count(),
                'total_symptoms' => Symptom::count(),
                'recent_diagnoses' => Diagnosis::with('user')->latest()->take(5)->get(),
                'popular_diseases' => DB::table('diagnoses')
                    ->select('disease_name', DB::raw('COUNT(*) as count'))
                    ->groupBy('disease_name')
                    ->orderBy('count', 'desc')
                    ->take(5)
                    ->get()
            ];

            return view('admin.tabs.dashboard', compact('stats'));
        } catch (Exception $e) {
            return "<div class='alert alert-danger'>Error loading dashboard: " . $e->getMessage() . "</div>";
        }
    }

    public function loadUsersTab()
    {
        try {
            $users = User::withCount('diagnoses')
                ->where('is_admin', false)
                ->latest()
                ->get();

            return view('admin.tabs.users', compact('users'));
        } catch (Exception $e) {
            return "<div class='alert alert-danger'>Error loading users: " . $e->getMessage() . "</div>";
        }
    }

    public function loadDiseasesTab()
    {
        try {
            $diseases = Disease::withCount('symptoms')->latest()->get();
            $symptoms = Symptom::where('is_active', true)->get();
            return view('admin.tabs.diseases', compact('diseases', 'symptoms'));
        } catch (Exception $e) {
            return "<div class='alert alert-danger'>Error loading diseases: " . $e->getMessage() . "</div>";
        }
    }

    public function loadSymptomsTab()
    {
        try {
            $symptoms = Symptom::withCount('diseases')
                ->orderBy('order', 'asc')
                ->orderBy('code', 'asc')
                ->get();

            Log::info('Symptoms loaded: ' . $symptoms->count());

            return view('admin.tabs.symptoms', compact('symptoms'));
        } catch (Exception $e) {
            Log::error('Error loading symptoms: ' . $e->getMessage());
            return "<div class='alert alert-danger'>Error loading symptoms: " . $e->getMessage() . "</div>";
        }
    }

    public function loadDiagnosesTab()
    {
        try {
            $diagnoses = Diagnosis::with('user')->latest()->paginate(10);
            return view('admin.tabs.diagnoses', compact('diagnoses'));
        } catch (Exception $e) {
            return "<div class='alert alert-danger'>Error loading diagnoses: " . $e->getMessage() . "</div>";
        }
    }

    public function loadSettingsTab()
    {
        try {
            return view('admin.tabs.settings');
        } catch (Exception $e) {
            return "<div class='alert alert-danger'>Error loading settings: " . $e->getMessage() . "</div>";
        }
    }

    // ==================== USER MANAGEMENT METHODS ====================
    public function getUser($id)
    {
        try {
            $user = User::withCount('diagnoses')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found: ' . $e->getMessage()
            ], 404);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'age' => 'nullable|integer|min:1|max:120',
                'gender' => 'nullable|in:male,female,other',
                'role' => 'nullable|in:user,admin'
            ]);

            // Update role jika disediakan
            if (isset($validated['role'])) {
                $user->is_admin = $validated['role'] === 'admin';
                unset($validated['role']);
            }

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting admin user
            if ($user->email === 'admin@dentalcare.com') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete main admin user'
                ], 400);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== DISEASE MANAGEMENT METHODS ====================
    public function getDisease($id)
    {
        try {
            $disease = Disease::with('symptoms')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $disease
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Disease not found: ' . $e->getMessage()
            ], 404);
        }
    }

    public function storeDisease(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:diseases',
                'description' => 'required|string',
                'treatment' => 'required|string',
                'prevention' => 'required|string',
                'causes' => 'required|string',
                'risk_factors' => 'required|string',
                'severity' => 'required|in:low,medium,high',
                'is_emergency' => 'boolean',
                'symptoms' => 'nullable|array'
            ]);

            $disease = Disease::create($validated);

            if ($request->has('symptoms')) {
                $disease->symptoms()->attach($request->symptoms);
            }

            return response()->json([
                'success' => true,
                'message' => 'Disease created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating disease: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateDisease(Request $request, $id)
    {
        try {
            $disease = Disease::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:diseases,name,' . $id,
                'description' => 'required|string',
                'treatment' => 'required|string',
                'prevention' => 'required|string',
                'causes' => 'required|string',
                'risk_factors' => 'required|string',
                'severity' => 'required|in:low,medium,high',
                'is_emergency' => 'boolean',
                'symptoms' => 'nullable|array'
            ]);

            $disease->update($validated);

            if ($request->has('symptoms')) {
                $disease->symptoms()->sync($request->symptoms);
            }

            return response()->json([
                'success' => true,
                'message' => 'Disease updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating disease: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteDisease($id)
    {
        try {
            $disease = Disease::findOrFail($id);
            $disease->delete();

            return response()->json([
                'success' => true,
                'message' => 'Disease deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting disease: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDiseaseSymptoms($id)
    {
        try {
            $disease = Disease::with('symptoms')->findOrFail($id);
            return response()->json([
                'success' => true,
                'symptoms' => $disease->symptoms
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading disease symptoms'
            ], 500);
        }
    }

    // ==================== SYMPTOM MANAGEMENT METHODS ====================
    public function getSymptom($id)
    {
        try {
            $symptom = Symptom::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $symptom
            ]);
        } catch (Exception $e) {
            Log::error('Error getting symptom: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Symptom not found: ' . $e->getMessage()
            ], 404);
        }
    }

    public function editSymptom($id)
    {
        try {
            $symptom = Symptom::findOrFail($id);
            return response()->json([
                'success' => true,
                'symptom' => $symptom
            ]);
        } catch (Exception $e) {
            Log::error('Error in editSymptom: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Symptom not found'
            ], 404);
        }
    }

    public function storeSymptom(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:10|unique:symptoms',
                'question' => 'required|string|max:500',
                'type' => 'required|in:yes_no,multiple_choice,scale',
                'options' => 'nullable|array',
                'order' => 'required|integer',
                'is_active' => 'boolean'
            ]);

            // Handle options conversion
            if (isset($validated['options'])) {
                $validated['options'] = $this->processOptions($validated['options'], $validated['type']);
            }

            Symptom::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Symptom created successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Error creating symptom: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating symptom: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSymptom(Request $request, $id)
    {
        try {
            $symptom = Symptom::findOrFail($id);

            $validated = $request->validate([
                'code' => 'required|string|max:10|unique:symptoms,code,' . $id,
                'question' => 'required|string|max:500',
                'type' => 'required|in:yes_no,multiple_choice,scale',
                'options' => 'nullable|array',
                'order' => 'required|integer',
                'is_active' => 'boolean'
            ]);

            // Handle options conversion
            if (isset($validated['options'])) {
                $validated['options'] = $this->processOptions($validated['options'], $validated['type']);
            } else {
                $validated['options'] = null;
            }

            $symptom->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Symptom updated successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Error updating symptom: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating symptom: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSymptom($id)
    {
        try {
            $symptom = Symptom::findOrFail($id);
            
            // Check if symptom is used in diseases
            if ($symptom->diseases()->count() > 0) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Cannot delete symptom. It is associated with ' . $symptom->diseases()->count() . ' disease(s).'
                ], 422);
            }

            $symptom->delete();

            return response()->json([
                'success' => true,
                'message' => 'Symptom deleted successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Error deleting symptom: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting symptom: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function toggleSymptomStatus(Request $request, $id)
    {
        try {
            $symptom = Symptom::findOrFail($id);
            
            $validated = $request->validate([
                'is_active' => 'required|boolean'
            ]);

            $symptom->update([
                'is_active' => $validated['is_active']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Symptom status updated successfully',
                'data' => [
                    'is_active' => $symptom->is_active
                ]
            ]);
        } catch (Exception $e) {
            Log::error('Error toggling symptom status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating symptom status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSymptomsList()
    {
        try {
            $symptoms = Symptom::where('is_active', true)
                ->orderBy('order', 'asc')
                ->orderBy('code', 'asc')
                ->get(['id', 'code', 'question']);

            return response()->json([
                'success' => true,
                'data' => $symptoms
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading symptoms list: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSymptomDiseases($id)
    {
        try {
            $symptom = Symptom::with('diseases')->findOrFail($id);
            return response()->json([
                'success' => true,
                'diseases' => $symptom->diseases
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading symptom diseases'
            ], 500);
        }
    }

    public function getSymptomsForDiagnosis()
    {
        try {
            $symptoms = Symptom::where('is_active', true)
                ->orderBy('order', 'asc')
                ->orderBy('code', 'asc')
                ->get(['id', 'code', 'question', 'type', 'options']);

            return response()->json([
                'success' => true,
                'data' => $symptoms
            ]);
        } catch (Exception $e) {
            Log::error('Error getting symptoms for diagnosis: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading symptoms'
            ], 500);
        }
    }

    private function processOptions($options, $type)
    {
        if (empty($options)) {
            return null;
        }

        // Filter out empty values
        $filteredOptions = array_filter($options, function($value) {
            return !empty(trim($value));
        });

        if (empty($filteredOptions)) {
            return null;
        }

        // For yes_no type, set default options if empty
        if ($type === 'yes_no' && empty($filteredOptions)) {
            return ['yes' => 'Ya', 'no' => 'Tidak'];
        }

        return $filteredOptions;
    }

    // ==================== DIAGNOSIS MANAGEMENT METHODS ====================
    public function getDiagnosis($id)
    {
        try {
            $diagnosis = Diagnosis::with('user')->findOrFail($id);
            return response()->json([
                'success' => true,
                'diagnosis' => $diagnosis
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Diagnosis not found'
            ], 404);
        }
    }

    public function deleteDiagnosis($id)
    {
        try {
            $diagnosis = Diagnosis::findOrFail($id);
            $diagnosis->delete();

            return response()->json([
                'success' => true,
                'message' => 'Diagnosis deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting diagnosis: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadDiagnosisPDF($id)
    {
        try {
            $diagnosis = Diagnosis::with('user')->findOrFail($id);
            
            if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                return response('PDF generation service is unavailable.', 500);
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.diagnosis.pdf', compact('diagnosis'));
            
            $filename = 'diagnosis-' . $diagnosis->id . '-' . $diagnosis->created_at->format('Y-m-d') . '.pdf';
            
            return $pdf->download($filename);

        } catch (Exception $e) {
            return response('Error generating PDF: ' . $e->getMessage(), 500);
        }
    }

    // ==================== EXPORT METHODS ====================
    public function exportUsers()
    {
        try {
            $users = User::withCount('diagnoses')->get();

            $filename = "users_export_" . date('Y-m-d') . ".csv";

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $handle = fopen('php://output', 'w');

            // Add BOM to fix UTF-8 in Excel
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['Name', 'Email', 'Age', 'Gender', 'Role', 'Total Diagnoses', 'Registered Date']);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->name,
                    $user->email,
                    $user->age ?? 'N/A',
                    $user->gender ?? 'N/A',
                    $user->is_admin ? 'Admin' : 'User',
                    $user->diagnoses_count,
                    $user->created_at->format('Y-m-d H:i')
                ]);
            }

            fclose($handle);
            exit;
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportDiagnoses()
    {
        try {
            $diagnoses = Diagnosis::with('user')->latest()->get();

            $filename = "diagnoses_export_" . date('Y-m-d') . ".csv";

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $handle = fopen('php://output', 'w');

            // Add BOM to fix UTF-8 in Excel
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['User Name', 'User Email', 'Disease', 'Confidence', 'Emergency', 'Symptoms Count', 'Date']);

            foreach ($diagnoses as $diagnosis) {
                $symptomsCount = $diagnosis->symptoms_checked ? count(json_decode($diagnosis->symptoms_checked, true)) : 0;

                fputcsv($handle, [
                    $diagnosis->user->name,
                    $diagnosis->user->email,
                    $diagnosis->disease_name,
                    $diagnosis->confidence_level . '%',
                    $diagnosis->is_emergency ? 'Yes' : 'No',
                    $symptomsCount,
                    $diagnosis->created_at->format('Y-m-d H:i')
                ]);
            }

            fclose($handle);
            exit;
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==================== SETTINGS METHODS ====================
    public function updateTheme(Request $request)
    {
        try {
            $validated = $request->validate([
                'theme' => 'required|in:light,dark,system'
            ]);

            // Store theme preference in session
            session(['theme' => $validated['theme']]);

            return response()->json([
                'success' => true,
                'message' => 'Theme updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating theme: ' . $e->getMessage()
            ], 500);
        }
    }
}