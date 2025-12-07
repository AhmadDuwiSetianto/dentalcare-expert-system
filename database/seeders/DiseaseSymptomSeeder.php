<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSymptomSeeder extends Seeder
{
    public function run()
    {
        // Clear existing relations
        DB::table('disease_symptom')->truncate();

        // 1. KARIES SUPERFISIAL
        // Total Maks: 13 + 1 (sekunder) = 14
        $kariesSuperfisial = Disease::where('name', 'Karies Superfisial')->first();
        $kariesSuperfisial->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q7')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q8')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q9')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q10')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q11')->id => ['weight' => 1], // GEJALA SEKUNDER (mungkin ada bau mulut jika lubang besar)
        ]);

        // 2. KARIES DALAM
        // Total Maks: 15 + 2 (sekunder) = 17
        $kariesDalam = Disease::where('name', 'Karies Dalam')->first();
        $kariesDalam->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q7')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q8')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q9')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q10')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q11')->id => ['weight' => 2], // GEJALA SEKUNDER (bau mulut)
        ]);

        // 3. PULPITIS IREVERSIBEL
        // Total Maks: 11 + 3 (sekunder) = 14
        $pulpitis = Disease::where('name', 'Pulpitis Ireversibel')->first();
        $pulpitis->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q2')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q3')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q8')->id => ['weight' => 2], // INTI (biasanya ada lubang)
            $this->findSymptom('Q4')->id => ['weight' => 1], // GEJALA SEKUNDER (gigi terasa tinggi)
            $this->findSymptom('Q5')->id => ['weight' => 1], // GEJALA SEKUNDER (pembengkakan awal)
            $this->findSymptom('Q11')->id => ['weight' => 1], // GEJALA SEKUNDER (bau mulut)
        ]);

        // 4. ABSCES PERIAPIKAL
        // Total Maks: 12 + 3 (sekunder) = 15
        $abses = Disease::where('name', 'Abses Periapikal')->first();
        $abses->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q2')->id => ['weight' => 3], // INTI (nyeri hebat)
            $this->findSymptom('Q4')->id => ['weight' => 3], // INTI (gigi terasa tinggi)
            $this->findSymptom('Q5')->id => ['weight' => 3], // INTI (pembengkakan)
            $this->findSymptom('Q8')->id => ['weight' => 1], // GEJALA SEKUNDER (mungkin ada lubang)
            $this->findSymptom('Q11')->id => ['weight' => 2], // GEJALA SEKUNDER (bau mulut khas)
        ]);

        // 5. GINGIVITIS
        // Total Maks: 5 + 1 (sekunder) = 6
        $gingivitis = Disease::where('name', 'Gingivitis')->first();
        $gingivitis->symptoms()->attach([
            $this->findSymptom('Q6')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q11')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q16')->id => ['weight' => 1], // GEJALA SEKUNDER (gusi bisa mulai turun sedikit)
        ]);

        // 6. PERIODONTITIS
        // Total Maks: 10 + 1 (sekunder) = 11
        $periodontitis = Disease::where('name', 'Periodontitis')->first();
        $periodontitis->symptoms()->attach([
            $this->findSymptom('Q6')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q11')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q15')->id => ['weight' => 3], // INTI (gigi goyang)
            $this->findSymptom('Q16')->id => ['weight' => 2], // INTI (gusi turun)
            $this->findSymptom('Q5')->id => ['weight' => 1], // GEJALA SEKUNDER (abses periodontal)
        ]);

        // 7. STOMATITIS AFTOSA
        // Total Maks: 6 + 1 (sekunder) = 7
        $stomatitis = Disease::where('name', 'Stomatitis Aftosa')->first();
        $stomatitis->symptoms()->attach([
            $this->findSymptom('Q12')->id => ['weight' => 3], // INTI (ada luka)
            $this->findSymptom('Q13')->id => ['weight' => 3], // INTI (bentuk khas sariawan)
            $this->findSymptom('Q1')->id => ['weight' => 1], // GEJALA SEKUNDER (nyeri, tapi dari luka, bukan gigi)
        ]);

        // 8. KANDIDIASIS ORAL
        // Total Maks: 5 + 1 (sekunder) = 6
        $kandidiasis = Disease::where('name', 'Kandidiasis Oral')->first();
        $kandidiasis->symptoms()->attach([
            $this->findSymptom('Q14')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q12')->id => ['weight' => 2], // INTI (luka/lesi)
            $this->findSymptom('Q7')->id => ['weight' => 1], // GEJALA SEKUNDER (perubahan warna)
        ]);

        // 9. BRUXISM
        // Total Maks: 5 + 2 (sekunder) = 7
        $bruxism = Disease::where('name', 'Bruxism')->first();
        $bruxism->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 2], // INTI (nyeri sendi/otot)
            $this->findSymptom('Q18')->id => ['weight' => 3], // INTI (menggertak gigi)
            $this->findSymptom('Q9')->id => ['weight' => 2], // GEJALA SEKUNDER (gigi sensitif)
        ]);

        // 10. GIGI IMPAKSI
        // Total Maks: 4 + 3 (sekunder) = 7
        $impaksi = Disease::where('name', 'Gigi Impaksi')->first();
        $impaksi->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q5')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q11')->id => ['weight' => 1], // GEJALA SEKUNDER (bau mulut dari perikoronitis)
            $this->findSymptom('Q6')->id => ['weight' => 2], // GEJALA SEKUNDER (gusi berdarah)
        ]);

        // 11. HIPERSENSITIVITAS DENTIN
        // Total Maks: 10 + 1 (sekunder) = 11
        $hipersensitif = Disease::where('name', 'Hipersensitivitas Dentin')->first();
        $hipersensitif->symptoms()->attach([
            $this->findSymptom('Q1')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q9')->id => ['weight' => 3], // INTI
            $this->findSymptom('Q10')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q16')->id => ['weight' => 2], // INTI
            $this->findSymptom('Q8')->id => ['weight' => 1], // GEJALA SEKUNDER (lubang/abrasi)
        ]);

        // 12. LEUKOPLAKIA
        // Total Maks: 5 + 3 (sekunder) = 8
        $leukoplakia = Disease::where('name', 'Leukoplakia')->first();
        $leukoplakia->symptoms()->attach([
            $this->findSymptom('Q7')->id => ['weight' => 3], // INTI (perubahan warna jadi putih)
            $this->findSymptom('Q17')->id => ['weight' => 2], // INTI (merokok)
            $this->findSymptom('Q12')->id => ['weight' => 2], // GEJALA SEKUNDER (dianggap luka/lesi)
            $this->findSymptom('Q1')->id => ['weight' => 1], // GEJALA SEKUNDER (kadang bisa nyeri)
        ]);

        // 13. XEROSTOMIA
        // Total Maks: 3 + 2 (sekunder) = 5
        $xerostomia = Disease::where('name', 'Xerostomia')->first();
        $xerostomia->symptoms()->attach([
            $this->findSymptom('Q11')->id => ['weight' => 2], // INTI (bau mulut karena kering)
            $this->findSymptom('Q12')->id => ['weight' => 1], // INTI (luka karena kering)
            $this->findSymptom('Q8')->id => ['weight' => 2], // GEJALA SEKUNDER (karies meningkat drastis)
        ]);

        $this->command->info('Berhasil menambahkan relasi penyakit-gejala ke database.');
    }

    private function findSymptom($code)
    {
        return Symptom::where('code', $code)->first();
    }
}
