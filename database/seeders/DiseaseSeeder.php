<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    public function run()
    {
        $diseases = [
            [
                'name' => 'Karies Superfisial',
                'description' => 'Karies pada lapisan email gigi tanpa mencapai dentin. Biasanya terjadi pada anak-anak dan remaja dengan konsumsi gula tinggi.',
                'treatment' => 'Penambalan gigi dengan bahan komposit atau amalgam. Fluoridasi topikal untuk memperkuat email.',
                'prevention' => 'Menjaga kebersihan mulut dengan menyikat gigi 2x sehari, mengurangi konsumsi gula, penggunaan dental floss, pemeriksaan rutin 6 bulan sekali.',
                'causes' => 'Akumulasi plak bakteri (Streptococcus mutans), konsumsi gula berlebihan, kebersihan mulut buruk.',
                'risk_factors' => 'Kebersihan mulut buruk, diet tinggi gula/karbohidrat, mulut kering, frekuensi makan sering.',
                'severity' => 'low',
                'is_emergency' => false
            ],
            [
                'name' => 'Karies Dalam',
                'description' => 'Karies yang telah mencapai dentin dan mendekati pulpa gigi. Dapat berkembang menjadi pulpitis jika tidak ditangani.',
                'treatment' => 'Penambalan, inlay/onlay, atau mahkota gigi. Jika mendekati pulpa mungkin perlu liner pelindung.',
                'prevention' => 'Perawatan gigi rutin, deteksi dini karies, diet seimbang, penggunaan pasta gigi berfluoride.',
                'causes' => 'Karies superfisial yang tidak dirawat, kebersihan mulut buruk berkepanjangan.',
                'risk_factors' => 'Karies sebelumnya, kebersihan mulut buruk, maloklusi, diet tinggi gula.',
                'severity' => 'medium',
                'is_emergency' => false
            ],
            [
                'name' => 'Pulpitis Ireversibel',
                'description' => 'Peradangan pulpa gigi yang tidak dapat disembuhkan. Kondisi ini memerlukan perawatan saluran akar.',
                'treatment' => 'Perawatan saluran akar (PSA) atau pencabutan gigi. Antibiotik jika ada infeksi sistemik.',
                'prevention' => 'Penanganan karies secara dini, hindari trauma gigi, pemeriksaan rutin.',
                'causes' => 'Karies dalam yang mencapai pulpa, trauma gigi, fraktur gigi, restorasi dalam.',
                'risk_factors' => 'Karies tidak dirawat, kebiasaan menggertakkan gigi, trauma oklusal.',
                'severity' => 'high',
                'is_emergency' => true
            ],
            [
                'name' => 'Abses Periapikal',
                'description' => 'Infeksi bakteri pada ujung akar gigi yang menyebabkan pengumpulan nanah. Seringkali merupakan komplikasi dari pulpitis ireversibel.',
                'treatment' => 'Drainase abses, perawatan saluran akar, antibiotik (amoxicillin/clindamycin), analgesik untuk nyeri.',
                'prevention' => 'Perawatan karies dan pulpitis secara tepat waktu, menjaga kesehatan gigi.',
                'causes' => 'Infeksi bakteri dari karies dalam, trauma gigi, kegagalan perawatan saluran akar sebelumnya.',
                'risk_factors' => 'Sistem imun lemah, diabetes, kebersihan mulut buruk.',
                'severity' => 'high',
                'is_emergency' => true
            ],
            [
                'name' => 'Gingivitis',
                'description' => 'Peradangan gusi tanpa kehilangan perlekatan tulang alveolar. Merupakan tahap awal penyakit periodontal.',
                'treatment' => 'Pembersihan karang gigi (scaling), edukasi oral hygiene, obat kumur antiseptik (chlorhexidine).',
                'prevention' => 'Menyikat gigi dan flossing secara teratur, pembersihan karang gigi rutin 6 bulan sekali.',
                'causes' => 'Akumulasi plak bakteri, karang gigi, kebersihan mulut buruk.',
                'risk_factors' => 'Kebersihan mulut buruk, merokok, diabetes, perubahan hormonal.',
                'severity' => 'low',
                'is_emergency' => false
            ],
            [
                'name' => 'Periodontitis',
                'description' => 'Peradangan gusi dengan kehilangan perlekatan dan tulang alveolar. Dapat menyebabkan kehilangan gigi jika tidak ditangani.',
                'treatment' => 'Scaling dan root planing, kuretase, antibiotik lokal/systemic, bedah periodontal pada kasus lanjut.',
                'prevention' => 'Kontrol plak yang baik, berhenti merokok, kontrol penyakit sistemik (diabetes), pemeriksaan rutin.',
                'causes' => 'Gingivitis yang tidak dirawat, akumulasi plak dan karang subgingiva.',
                'risk_factors' => 'Merokok, diabetes, faktor genetik, stres, obat-obatan tertentu.',
                'severity' => 'medium',
                'is_emergency' => false
            ],
            [
                'name' => 'Stomatitis Aftosa',
                'description' => 'Sariawan biasa yang berupa luka dangkal di mukosa mulut. Biasanya sembuh sendiri dalam 7-14 hari.',
                'treatment' => 'Obat topikal (triamcinolone acetonide), analgesik topikal, hindari makanan pedas/asam, menjaga kebersihan mulut.',
                'prevention' => 'Hindari trauma, kelola stres, diet seimbang, identifikasi dan hindari alergen.',
                'causes' => 'Stres, trauma fisik (tergigit), defisiensi nutrisi (B12, zat besi), alergi makanan, faktor genetik.',
                'risk_factors' => 'Stres, imunosupresi, defisiensi nutrisi, riwayat keluarga.',
                'severity' => 'low',
                'is_emergency' => false
            ],
            [
                'name' => 'Kandidiasis Oral',
                'description' => 'Infeksi jamur Candida albicans pada rongga mulut. Sering terjadi pada individu dengan sistem imun lemah.',
                'treatment' => 'Antijamur topikal (nystatin, miconazole), antijamur sistemik (fluconazole) untuk kasus berat, desinfeksi gigi tiruan.',
                'prevention' => 'Menjaga kebersihan mulut dan gigi tiruan, kontrol penyakit sistemik, hindari antibiotik tidak perlu.',
                'causes' => 'Jamur Candida albicans, sistem imun lemah, penggunaan antibiotik/kortikosteroid jangka panjang.',
                'risk_factors' => 'Diabetes, HIV/AIDS, kemoterapi, penggunaan steroid, gigi tiruan, usia lanjut.',
                'severity' => 'medium',
                'is_emergency' => false
            ],
            [
                'name' => 'Bruxism',
                'description' => 'Kebiasaan menggemeretakkan atau mengatupkan gigi secara tidak sadar, biasanya terjadi saat tidur.',
                'treatment' => 'Occlusal splint/mouthguard, terapi relaksasi, fisioterapi, injeksi botox pada kasus berat, koreksi oklusi.',
                'prevention' => 'Manajemen stres, hindari kafein dan alkohol, terapi perilaku, pemeriksaan rutin.',
                'causes' => 'Stres dan kecemasan, maloklusi, sleep disorder, faktor genetik, obat-obatan tertentu.',
                'risk_factors' => 'Stres, tipe kepribadian tertentu, konsumsi alkohol/kafein, sleep apnea.',
                'severity' => 'medium',
                'is_emergency' => false
            ],
            [
                'name' => 'Gigi Impaksi',
                'description' => 'Gigi yang gagal erupsi sempurna ke dalam posisi fungsionalnya, paling sering terjadi pada molar ketiga (gigi bungsu).',
                'treatment' => 'Pencabutan gigi impaksi (odontectomy), antibiotik jika ada infeksi, analgesik untuk nyeri.',
                'prevention' => 'Pemeriksaan radiografi rutin, pencabutan preventif pada indikasi tertentu.',
                'causes' => 'Kurangnya ruang di rahang, arah erupsi abnormal, gigi berlebih, tumor atau kista.',
                'risk_factors' => 'Usia dewasa muda, faktor genetik, ukuran rahang kecil, gigi berlebih.',
                'severity' => 'medium',
                'is_emergency' => false
            ],
            [
                'name' => 'Hipersensitivitas Dentin',
                'description' => 'Kondisi dimana dentin terekspos dan menyebabkan nyeri singkat saat terpapar rangsangan tertentu.',
                'treatment' => 'Pasta gigi desensitizing, aplikasi fluoride/desensitizer di klinik, bonding agent, restorasi, perawatan saluran akar pada kasus berat.',
                'prevention' => 'Teknik menyikat gigi yang benar, hindari menyikat terlalu keras, kontrol diet asam.',
                'causes' => 'Resesi gusi, abrasi/erosi gigi, penyakit periodontal, bruxism.',
                'risk_factors' => 'Menyikat gigi terlalu keras, diet tinggi asam, penyakit gusi, bruxism.',
                'severity' => 'low',
                'is_emergency' => false
            ],
            [
                'name' => 'Leukoplakia',
                'description' => 'Bercak putih atau abu-abu di mukosa mulut yang tidak dapat dihapus dengan menggosok. Merupakan lesi pra-kanker.',
                'treatment' => 'Biopsi untuk diagnosis pasti, eksisi bedah, monitoring ketat, berhenti merokok/alkohol.',
                'prevention' => 'Berhenti merokok/tembakau, hindari alkohol berlebihan, pemeriksaan rutin mulut.',
                'causes' => 'Iritasi kronis (rokok, alkohol), gigi palsu tidak pas, mengunyah tembakau.',
                'risk_factors' => 'Merokok, konsumsi alkohol, usia >60 tahun, infeksi HPV.',
                'severity' => 'high',
                'is_emergency' => false
            ],
            [
                'name' => 'Xerostomia',
                'description' => 'Kondisi mulut kering akibat berkurangnya produksi air liur. Dapat menyebabkan berbagai masalah gigi dan mulut.',
                'treatment' => 'Air liur artifisial, stimulan saliva (pilocarpine), permen karet bebas gula, hindari obat penyebab mulut kering jika memungkinkan.',
                'prevention' => 'Minum air cukup, hindari kafein/alkohol, humidifier saat tidur, kontrol penyakit sistemik.',
                'causes' => 'Efek samping obat, penyakit autoimun (Sjogren syndrome), radioterapi kepala-leher, diabetes.',
                'risk_factors' => 'Penggunaan multiple obat, usia lanjut, penyakit autoimun, radioterapi.',
                'severity' => 'medium',
                'is_emergency' => false
            ]
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }

        $this->command->info('Berhasil menambahkan ' . count($diseases) . ' penyakit ke database.');
    }
}