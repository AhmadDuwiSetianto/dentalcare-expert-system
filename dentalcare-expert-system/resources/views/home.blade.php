@extends('layouts.app')

@section('title', 'Beranda - DentalCare Expert')

@section('content')
<!-- Hero Section -->
<section class="responsive-py">
    <div class="container">
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-6xl font-bold mb-4 md:mb-6">
                <span class="gradient-text">DentalCare Expert</span>
            </h1>
            <p class="text-lg md:text-2xl text-gray-300 max-w-3xl mx-auto mb-6 md:mb-8 px-4">
                Sistem Pakar Cerdas untuk Diagnosis Penyakit Gigi dan Mulut
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-4 px-4 landing-header">
                @auth
                <a href="{{ route('diagnosis.index') }}" class="btn-gradient text-base md:text-lg px-6 md:px-8 py-3 md:py-4">
                    <i class="fas fa-stethoscope mr-2 md:mr-3"></i>
                    <span>Mulai Diagnosa</span>
                </a>
                <a href="#features" class="bg-transparent border border-white/30 text-white px-6 md:px-8 py-3 md:py-4 rounded-full text-base md:text-lg hover:bg-white/10 transition-all">
                    <i class="fas fa-info-circle mr-2 md:mr-3"></i>
                    <span>Pelajari Lebih Lanjut</span>
                </a>
                @else
                <div class="text-center py-8 md:py-12">
                    <div class="mb-4 md:mb-6">
                        <i class="fas fa-robot text-4xl md:text-6xl gradient-text mb-3 md:mb-4"></i>
                    </div>
                    <a href="{{ route('diagnosis.index') }}" class="btn-gradient text-base md:text-lg py-2 md:py-3 px-6 md:px-8">
                        <i class="fas fa-play mr-2"></i>Mulai Diagnosa
                    </a>
                </div>
                @endauth
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-12 md:mb-16 px-4">
            <div class="stats-card text-center">
                <div class="text-2xl md:text-4xl font-bold gradient-text mb-2">95%</div>
                <p class="text-gray-300 text-sm md:text-base">Akurasi Diagnosa</p>
            </div>
            <div class="stats-card text-center">
                <div class="text-2xl md:text-4xl font-bold gradient-text mb-2">50+</div>
                <p class="text-gray-300 text-sm md:text-base">Jenis Penyakit Terdeteksi</p>
            </div>
            <div class="stats-card text-center">
                <div class="text-2xl md:text-4xl font-bold gradient-text mb-2">24/7</div>
                <p class="text-gray-300 text-sm md:text-base">Konsultasi Tersedia</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="responsive-py bg-black/20">
    <div class="container">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-2xl md:text-4xl font-bold mb-4 md:mb-6 gradient-text">Fitur Unggulan</h2>
            <p class="text-gray-300 max-w-2xl mx-auto text-base md:text-lg px-4 leading-relaxed">
                DentalCare Expert menyediakan berbagai fitur canggih untuk membantu diagnosis masalah gigi dan mulut Anda
            </p>
        </div>

        <div class="features-container px-4">
            <!-- Diagnosa AI -->
            <div class="feature-item">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="feature-content">
                    <h3 class="feature-heading">Diagnosa AI</h3>
                    <p class="feature-text">
                        Sistem kecerdasan buatan yang dapat menganalisis gejala dan memberikan diagnosis akurat
                        untuk masalah gigi dan mulut.
                    </p>
                </div>
            </div>

            <!-- Riwayat Diagnosa -->
            <div class="feature-item">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-history"></i>
                </div>
                <div class="feature-content">
                    <h3 class="feature-heading">Riwayat Diagnosa</h3>
                    <p class="feature-text">
                        Simpan dan kelola riwayat diagnosis untuk memantau perkembangan kesehatan
                        gigi dan mulut Anda.
                    </p>
                </div>
            </div>

            <!-- Rekomendasi Tindakan -->
            <div class="feature-item">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="feature-content">
                    <h3 class="feature-heading">Rekomendasi Tindakan</h3>
                    <p class="feature-text">
                        Dapatkan saran dan rekomendasi tindakan medis berdasarkan hasil diagnosis yang diberikan.
                    </p>
                </div>
            </div>

            <!-- Keamanan Data -->
            <div class="feature-item">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="feature-content">
                    <h3 class="feature-heading">Keamanan Data</h3>
                    <p class="feature-text">
                        Data pribadi dan riwayat kesehatan Anda terlindungi dengan sistem keamanan berlapis.
                    </p>
                </div>
            </div>

            <!-- Akses Mudah -->
            <div class="feature-item">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="feature-content">
                    <h3 class="feature-heading">Akses Mudah</h3>
                    <p class="feature-text">
                        Akses sistem kapan saja dan di mana saja melalui perangkat desktop maupun mobile.
                    </p>
                </div>
            </div>

            <!-- Update Berkala -->
            <div class="feature-item">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="feature-content">
                    <h3 class="feature-heading">Update Berkala</h3>
                    <p class="feature-text">
                        Sistem terus diperbarui dengan data dan pengetahuan terbaru dari para ahli kedokteran gigi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="responsive-py">
    <div class="container">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-4xl font-bold mb-3 md:mb-4 gradient-text">Cara Kerja Sistem</h2>
            <p class="text-gray-300 max-w-2xl mx-auto text-sm md:text-base px-4">Proses diagnosis yang sederhana namun akurat dalam beberapa langkah mudah</p>
        </div>

        <div class="workflow-grid px-4">
            <div class="workflow-step">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="step-title">Pilih Gejala</h3>
                <p class="step-description">Pilih gejala yang Anda alami dari daftar yang tersedia.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 class="step-title">Analisis AI</h3>
                <p class="step-description">Sistem AI menganalisis gejala menggunakan basis pengetahuan ahli.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="fas fa-diagnoses"></i>
                </div>
                <h3 class="step-title">Hasil Diagnosa</h3>
                <p class="step-description">Dapatkan hasil diagnosis dengan tingkat akurasi tinggi.</p>
            </div>

            <div class="workflow-step">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <h3 class="step-title">Rekomendasi</h3>
                <p class="step-description">Terima saran tindakan dan perawatan yang disarankan.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="responsive-py bg-gradient-to-r from-blue-900/30 to-purple-900/30">
    <div class="container">
        <div class="text-center max-w-3xl mx-auto px-4">
            <h2 class="text-2xl md:text-4xl font-bold mb-4 md:mb-6">Siap Memulai Diagnosis?</h2>
            <p class="text-gray-300 mb-6 md:mb-8 text-sm md:text-lg">
                Bergabunglah dengan DentalCare Expert sekarang dan dapatkan diagnosis awal untuk masalah gigi dan mulut Anda secara gratis.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-4">
                @auth
                <a href="{{ route('diagnosis.index') }}" class="btn-gradient text-base md:text-lg px-6 md:px-8 py-3 md:py-4">
                    <i class="fas fa-stethoscope mr-2 md:mr-3"></i>Mulai Diagnosa Sekarang
                </a>
                @else
                <div class="text-center py-8 md:py-12">
                    <div class="mb-4 md:mb-6">
                        <i class="fas fa-robot text-4xl md:text-6xl gradient-text mb-3 md:mb-4"></i>
                    </div>
                    <a href="{{ route('diagnosis.index') }}" class="btn-gradient text-base md:text-lg py-2 md:py-3 px-6 md:px-8">
                        <i class="fas fa-play mr-2"></i>Mulai Diagnosa
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="responsive-py">
    <div class="container">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-4xl font-bold mb-3 md:mb-4 gradient-text">Pertanyaan Umum</h2>
            <p class="text-gray-300 max-w-2xl mx-auto text-sm md:text-base px-4">Temukan jawaban untuk pertanyaan yang sering diajukan tentang DentalCare Expert</p>
        </div>

        <div class="faq-container max-w-3xl mx-auto px-4">
            <div class="faq-item">
                <h3 class="faq-question">
                    <i class="fas fa-question-circle faq-icon"></i>
                    Apakah diagnosis dari sistem ini menggantikan dokter gigi?
                </h3>
                <p class="faq-answer">
                    Tidak, DentalCare Expert adalah alat bantu diagnosis awal. Hasil diagnosis harus dikonfirmasi oleh dokter gigi profesional untuk penanganan lebih lanjut.
                </p>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">
                    <i class="fas fa-question-circle faq-icon"></i>
                    Berapa tingkat akurasi sistem ini?
                </h3>
                <p class="faq-answer">
                    Sistem kami memiliki tingkat akurasi hingga 95% berdasarkan pengujian dengan data medis yang valid. Namun, diagnosis akhir tetap harus dilakukan oleh tenaga medis profesional.
                </p>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">
                    <i class="fas fa-question-circle faq-icon"></i>
                    Apakah data saya aman?
                </h3>
                <p class="faq-answer">
                    Ya, kami menggunakan enkripsi tingkat tinggi untuk melindungi data pribadi dan riwayat kesehatan Anda. Data tidak akan dibagikan kepada pihak ketiga tanpa izin.
                </p>
            </div>

            <div class="faq-item">
                <h3 class="faq-question">
                    <i class="fas fa-question-circle faq-icon"></i>
                    Apakah layanan ini berbayar?
                </h3>
                <p class="faq-answer">
                    Saat ini, DentalCare Expert menyediakan layanan diagnosis dasar secara gratis. Fitur premium mungkin akan tersedia di masa depan dengan tambahan manfaat.
                </p>
            </div>
        </div>
    </div>
</section>
<footer class="responsive-py bg-black/30 border-t border-white/10">
    <div class="container">
        <div class="text-center">
            <!-- Logo/Title -->
            <div class="mb-6">
                <h3 class="text-xl font-bold gradient-text mb-2">DentalCare Expert</h3>
                <p class="text-gray-300">Sistem Pakar Diagnosis Penyakit Gigi dan Mulut</p>
            </div>

            <!-- Team Information -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-4 text-white">Tim Pengembang</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    <div class="team-member">
                        <div class="text-white font-medium">M. Irfani Shurur</div>
                        <div class="text-gray-400 text-sm">101220028</div>
                    </div>
                    <div class="team-member">
                        <div class="text-white font-medium">Ardanu Malik R.</div>
                        <div class="text-gray-400 text-sm">101220051</div>
                    </div>
                    <div class="team-member">
                        <div class="text-white font-medium">Ahmad Duwi Setianto</div>
                        <div class="text-gray-400 text-sm">101220095</div>
                    </div>
                    <div class="team-member">
                        <div class="text-white font-medium">Mawadah Nurul Hikmah</div>
                        <div class="text-gray-400 text-sm">101220118</div>
                    </div>
                </div>
            </div>
            <div class="pt-6 border-t border-white/10">
                <p class="text-gray-500 text-sm">
                    © 2024 DentalCare Expert - Project Sistem Pakar | All rights reserved
                </p>
            </div>
        </div>
    </div>
</footer>
@endsection

<style>
    /* Base Styles */
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .responsive-py {
        padding: 3rem 0;
    }

    @media (min-width: 768px) {
        .responsive-py {
            padding: 5rem 0;
        }
    }

    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 12px 24px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    /* Stats Section */
    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.08);
    }

    /* Features Section - PERBAIKAN UTAMA */
    .features-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        justify-items: center;
    }

    .feature-item {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 500px;
        box-sizing: border-box;
    }

    .feature-item:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .feature-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        flex-shrink: 0;
    }

    .feature-content {
        flex: 1;
    }

    .feature-heading {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .feature-text {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        font-size: 1rem;
        margin: 0;
    }
    .team-member {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.team-member:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateY(-2px);
}
    /* How It Works Section */
    .workflow-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .workflow-step {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .workflow-step:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.08);
    }

    .step-number {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .step-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        margin-top: 1rem;
    }

    .step-icon:nth-child(1) { color: #3b82f6; }
    .step-icon:nth-child(2) { color: #8b5cf6; }
    .step-icon:nth-child(3) { color: #10b981; }
    .step-icon:nth-child(4) { color: #f59e0b; }

    .step-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .step-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0;
    }

    /* FAQ Section */
    .faq-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .faq-item {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .faq-question {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .faq-icon {
        color: #667eea;
        font-size: 1.2rem;
    }

    .faq-answer {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        margin: 0;
        padding-left: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .features-container {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.25rem;
        }
        
        .feature-item {
            padding: 1.75rem;
            gap: 1.25rem;
        }
        
        .feature-icon-wrapper {
            width: 60px;
            height: 60px;
            font-size: 1.6rem;
        }
        
        .feature-heading {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 768px) {
        .features-container {
            grid-template-columns: 1fr;
            gap: 1.25rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .feature-item {
            padding: 1.5rem;
            gap: 1rem;
        }

        .feature-icon-wrapper {
            width: 55px;
            height: 55px;
            font-size: 1.4rem;
        }

        .feature-heading {
            font-size: 1.2rem;
        }

        .feature-text {
            font-size: 0.95rem;
        }

        .workflow-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }
    }

    @media (max-width: 480px) {
        .feature-item {
            padding: 1.25rem;
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .feature-icon-wrapper {
            margin: 0 auto;
        }

        .faq-question {
            font-size: 1rem;
        }
        
        .faq-answer {
            padding-left: 1.5rem;
            font-size: 0.9rem;
        }
        
</style>