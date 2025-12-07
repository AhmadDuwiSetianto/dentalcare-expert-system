@extends('layouts.app')

@section('title', 'Diagnosa - DentalCare Expert')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="card-glass mb-6">
            <div class="flex flex-row justify-center items-center border-b border-white/10 pb-4 mb-6 overflow-x-auto">
                <div class="flex flex-row space-x-2 min-w-max">
                    <button type="button" class="tab-btn active" data-tab="start" data-route="/diagnosis/load/start">
                        <i class="fas fa-stethoscope mr-2"></i>
                        <span class="tab-text">Diagnosa</span>
                    </button>
                    <button type="button" class="tab-btn" data-tab="result" data-route="/diagnosis/load/result">
                        <i class="fas fa-chart-line mr-2"></i>
                        <span class="tab-text">Hasil</span>
                    </button>
                    <button type="button" class="tab-btn" data-tab="information" data-route="/diagnosis/load/information">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span class="tab-text">Informasi</span>
                    </button>
                    <button type="button" class="tab-btn hidden" data-tab="history" data-route="/diagnosis/load/history" style="display:none;">
                        History
                    </button>
                </div>
            </div>

            <div class="tab-content-wrapper relative min-h-[400px]">
                <div class="tab-content active" id="start-tab">
                    <div class="text-center py-8">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-stethoscope text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Mulai Diagnosa</h3>
                        <p class="text-gray-300 text-base mb-6 max-w-md mx-auto leading-relaxed">
                            Jawab beberapa pertanyaan untuk mendapatkan diagnosis awal masalah gigi dan mulut Anda.
                        </p>
                        <button type="button" onclick="startDiagnosis()" class="btn-gradient">
                            <i class="fas fa-play mr-2"></i>
                            <span>Mulai Diagnosa</span>
                        </button>
                        <p class="text-gray-400 text-sm mt-4 max-w-md mx-auto">
                            Sistem akan menanyakan gejala yang Anda alami untuk menentukan diagnosis yang tepat.
                        </p>
                    </div>
                </div>

                <div class="tab-content hidden" id="result-tab"></div>

                <div class="tab-content hidden" id="information-tab"></div>

                <div class="tab-content hidden" id="history-tab"></div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UTAMA --}}
<script>
    // 1. SETUP CSRF TOKEN (Wajib untuk request AJAX)
    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        // Fallback create jika tidak ada
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
        csrfToken = '{{ csrf_token() }}';
    }

    // ============================================================
    //  GLOBAL VARIABLES UNTUK DIAGNOSA
    // ============================================================
    window.diagnosisState = {
        step: 1,
        answers: {},
        currentQuestionId: null
    };

    // ============================================================
    //  GLOBAL FUNCTIONS (Dapat dipanggil dari mana saja)
    // ============================================================

    /**
     * FUNGSI DOWNLOAD PDF (FIXED)
     * Menggunakan window.location.href untuk direct download
     */
    window.downloadPDF = function(button) {
        console.log('📥 Tombol download diklik!');

        const diagnosisId = button.getAttribute('data-id');

        if (!diagnosisId) {
            alert('Error: ID Diagnosis tidak ditemukan. Silakan refresh halaman.');
            return;
        }

        // Simpan text asli tombol
        const originalContent = button.innerHTML;
        
        // Ubah jadi loading
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        button.style.opacity = '0.7';
        button.style.pointerEvents = 'none';

        // Direct Link - Browser akan menangani download otomatis
        const url = `/diagnosis/${diagnosisId}/download-pdf`;
        window.location.href = url;

        // Reset tombol setelah 3 detik
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.style.opacity = '1';
            button.style.pointerEvents = 'auto';
        }, 3000);
    };

    /**
     * Navigasi ke Tab History
     */
    window.handleViewHistory = function() {
        console.log('🔄 Navigasi ke History...');
        const historyBtn = document.querySelector('button[data-tab="history"]');
        if(historyBtn) {
            // historyBtn.style.display = 'flex'; // Uncomment jika ingin menampilkan tab history
            historyBtn.click();
        } else {
            loadTabContent('history', '/diagnosis/load/history');
        }
    };

    /**
     * Mulai Diagnosa Baru (Reset)
     */
    window.handleNewDiagnosis = function() {
        console.log('🔄 Diagnosa Baru...');
        startDiagnosis();
    };

    /**
     * Inisialisasi Proses Diagnosa
     */
    window.startDiagnosis = function() {
        console.log('🚀 Memulai proses diagnosa...');
        
        // Reset state
        window.diagnosisState = { step: 1, answers: {}, currentQuestionId: null };
        
        // Pindah ke tab start jika belum
        const startTabBtn = document.querySelector('[data-tab="start"]');
        if (startTabBtn && !startTabBtn.classList.contains('active')) {
            // Klik manual tab start, lalu load konten
            startTabBtn.click();
        } else {
            // Sudah di tab start, load konten start
            loadTabContent('start', '/diagnosis/load/start');
        }
    };

    /**
     * Core Function: Load Konten Tab via AJAX
     */
    window.loadTabContent = function(tab, route) {
        const tabContent = document.getElementById(tab + '-tab');
        if (!tabContent) return;

        console.log(`🔄 Loading konten tab: ${tab}`);
        
        // Tampilkan loading spinner
        tabContent.innerHTML = `
            <div class="text-center py-8">
                <div class="spinner mb-4"></div>
                <p class="text-gray-300 text-base">Memuat data...</p>
            </div>
        `;

        fetch(route, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.text();
        })
        .then(html => {
            tabContent.innerHTML = html;

            // Jika ini tab start, dan kita dalam mode diagnosa, jalankan logika diagnosa
            if (tab === 'start') {
                setTimeout(() => {
                    // Cek apakah ada container pertanyaan
                    if(document.getElementById('questionContainer')) {
                        loadQuestion(1);
                    }
                }, 100);
            }
            
            // Animasi Fade In
            tabContent.style.opacity = '0';
            tabContent.style.transform = 'translateY(10px)';
            setTimeout(() => {
                tabContent.style.transition = 'all 0.3s ease';
                tabContent.style.opacity = '1';
                tabContent.style.transform = 'translateY(0)';
            }, 50);
        })
        .catch(error => {
            console.error('❌ Error loading tab:', error);
            tabContent.innerHTML = `
                <div class="text-center py-8 text-red-400">
                    <i class="fas fa-exclamation-triangle text-3xl mb-3"></i>
                    <p>Gagal memuat konten: ${error.message}</p>
                    <button onclick="loadTabContent('${tab}', '${route}')" class="btn-gradient mt-4">
                        <i class="fas fa-redo mr-2"></i>Coba Lagi
                    </button>
                </div>
            `;
        });
    };

    // ============================================================
    //  LOGIKA DIAGNOSA (Load Question, Process Answer)
    // ============================================================

    // Load Pertanyaan dari Server
    window.loadQuestion = function(step) {
        console.log(`📥 Mengambil pertanyaan step: ${step}`);
        
        const container = document.getElementById('questionContainer');
        if(container) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <div class="spinner"></div>
                    <p class="text-gray-400 mt-4">Memuat pertanyaan...</p>
                </div>`;
        }

        fetch('/diagnosis/question', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                step: step,
                answers: window.diagnosisState.answers
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                if(data.completed) {
                    showResult(data.result, data.diagnosis_id);
                } else {
                    displayQuestion(data.question, data.step, data.progress);
                }
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            if(container) container.innerHTML = `<div class="text-red-400 text-center">Gagal memuat pertanyaan.</div>`;
        });
    };

    // Tampilkan Pertanyaan ke UI
    function displayQuestion(question, step, progress) {
        window.diagnosisState.step = step;
        window.diagnosisState.currentQuestionId = question.id;

        // Update Progress Bar
        const pFill = document.getElementById('progressFill');
        const pText = document.getElementById('progressText');
        if(pFill) pFill.style.width = `${progress}%`;
        if(pText) pText.innerText = `${progress}%`;

        // Render Pertanyaan
        const container = document.getElementById('questionContainer');
        if(!container) return;

        let html = `
            <div class="question-content fade-in">
                <h3 class="question-text text-lg font-semibold mb-6 text-white">${question.text}</h3>
                <div class="answer-options space-y-3">
                    <button type="button" onclick="selectAnswer('yes')" class="answer-btn w-full text-left p-4 border border-gray-600 rounded-lg hover:border-blue-500 transition-colors text-white group">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full border-2 border-gray-500 mr-3 flex items-center justify-center group-hover:border-blue-500">
                                <div class="w-3 h-3 rounded-full bg-blue-500 hidden selected-indicator"></div>
                            </div>
                            <span>Ya</span>
                        </div>
                    </button>
                    <button type="button" onclick="selectAnswer('no')" class="answer-btn w-full text-left p-4 border border-gray-600 rounded-lg hover:border-blue-500 transition-colors text-white group">
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full border-2 border-gray-500 mr-3 flex items-center justify-center group-hover:border-blue-500">
                                <div class="w-3 h-3 rounded-full bg-blue-500 hidden selected-indicator"></div>
                            </div>
                            <span>Tidak</span>
                        </div>
                    </button>
                </div>
            </div>
        `;
        
        container.innerHTML = html;

        // Show/Hide Nav Buttons
        const navBtns = document.getElementById('navButtons');
        if(navBtns) navBtns.style.display = 'flex';
        
        // Disable next btn initially
        const nextBtn = document.getElementById('nextBtn');
        if(nextBtn) nextBtn.disabled = true;
    }

    // Handle User Klik Jawaban
    window.selectAnswer = function(value) {
        // Visual selection logic
        document.querySelectorAll('.answer-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'bg-blue-500/10');
            btn.querySelector('.selected-indicator').classList.add('hidden');
        });
        
        // Highlight selected
        const selectedBtn = event.currentTarget;
        selectedBtn.classList.add('border-blue-500', 'bg-blue-500/10');
        selectedBtn.querySelector('.selected-indicator').classList.remove('hidden');

        // Enable Next
        const nextBtn = document.getElementById('nextBtn');
        if(nextBtn) {
            nextBtn.disabled = false;
            // Attach value to next button for processing
            nextBtn.setAttribute('data-answer', value);
        }
    };

    // Handle Tombol Next
    window.handleNextButton = function() {
        const nextBtn = document.getElementById('nextBtn');
        const answer = nextBtn.getAttribute('data-answer');
        
        if(!answer) return;

        // Simpan jawaban
        const qId = window.diagnosisState.currentQuestionId;
        window.diagnosisState.answers['q' + qId] = answer;

        // Kirim ke server
        processAnswer(window.diagnosisState.step, answer);
    };

    // Kirim Jawaban ke Server
    function processAnswer(step, answer) {
        fetch('/diagnosis/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                step: step,
                answer: answer,
                answers: window.diagnosisState.answers
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                if(data.completed) {
                    showResult(data.result, data.diagnosis_id);
                } else {
                    displayQuestion(data.question, data.step, data.progress);
                }
            }
        })
        .catch(console.error);
    }

    // Tampilkan Hasil (Pindah Tab)
    function showResult(result, diagnosisId) {
        console.log('🏁 Diagnosis Selesai. ID:', diagnosisId);
        
        // Pindah ke tab result
        const resultTabBtn = document.querySelector('button[data-tab="result"]');
        if(resultTabBtn) {
            resultTabBtn.click(); // Ini akan trigger loadTabContent('result')
        }
    }

    // ============================================================
    //  EVENT LISTENERS (DOM READY)
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📄 DOM Loaded');

        // Tab Navigation Logic
        const tabButtons = document.querySelectorAll('.tab-btn');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                const route = this.getAttribute('data-route');

                // 1. Update UI Buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                // 2. Hide All Contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                    content.style.display = 'none';
                });

                // 3. Show Target Content
                const targetContent = document.getElementById(targetTab + '-tab');
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                    targetContent.classList.add('active');
                    targetContent.style.display = 'block';

                    // 4. Load Content (Jika bukan tab start awal)
                    if (route) {
                        loadTabContent(targetTab, route);
                    }
                }
            });
        });
        
        // Event Delegation untuk Tombol Navigasi Diagnosa (Prev/Next)
        // Karena tombol ini dinamis, kita pakai delegation pada body atau container
        document.body.addEventListener('click', function(e) {
            if(e.target && e.target.id == 'nextBtn') {
                handleNextButton();
            }
            // Tambahkan prevBtn logic jika diperlukan
        });
    });

</script>


<style>
    .tab-btn {
        padding: 10px 20px;
        border-radius: 10px;
        color: #9CA3AF;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        font-weight: 500;
        border: none;
        cursor: pointer;
        background: transparent;
        flex-shrink: 0;
        min-width: max-content;
        justify-content: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        font-size: 14px;
        white-space: nowrap;
        height: 42px;
    }

    .tab-btn:hover {
        color: white;
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-1px);
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        transform: translateY(-1px);
    }

    .tab-btn.active::before {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 2px;
        background: white;
        border-radius: 1px;
    }

    .tab-content-wrapper {
        position: relative;
        min-height: 400px;
    }

    .tab-content {
        transition: all 0.3s ease;
        opacity: 1;
        transform: translateY(0);
        width: 100%;
    }

    .tab-content:not(.active) {
        display: none !important;
    }

    .tab-content.active {
        display: block !important;
    }

    .card-glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        margin-top: 0;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-gradient:active {
        transform: translateY(0);
    }

    .tab-text {
        display: inline-block;
        font-size: 14px;
        font-weight: 500;
    }

    .diagnosis-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .diagnosis-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 2rem;
    }

    .diagnosis-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .diagnosis-subtitle {
        color: #9CA3AF;
        text-align: center;
        margin-bottom: 2rem;
    }

    .progress-container {
        margin-bottom: 1.5rem;
    }

    .progress-bar {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
    }

    .progress-fill {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        height: 100%;
        transition: width 0.3s ease;
    }

    .progress-text {
        color: #9CA3AF;
        font-size: 0.875rem;
    }

    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .answer-btn {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .answer-btn:hover {
        transform: translateY(-2px);
        border-color: #3b82f6 !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover:not(:disabled) {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    .btn-secondary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .question-text {
        line-height: 1.6;
        font-size: 1.125rem;
    }

    .answer-options {
        max-height: 300px;
        overflow-y: auto;
    }

    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .card-glass {
            padding: 1.5rem;
            margin: 0;
            border-radius: 12px;
        }

        .flex-row.justify-center.items-center {
            overflow-x: auto;
            padding-bottom: 8px;
            justify-content: flex-start;
        }

        .flex-row.justify-center.items-center::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            padding: 8px 16px;
            font-size: 13px;
            flex-shrink: 0;
            height: 38px;
        }

        .tab-btn i {
            margin-right: 6px;
            font-size: 14px;
        }

        .btn-gradient {
            padding: 10px 20px;
            font-size: 13px;
        }

        .tab-text {
            font-size: 13px;
        }

        .tab-content:not(.active) {
            display: none !important;
        }

        .tab-content.active {
            display: block !important;
        }
    }

    @media (max-width: 640px) {
        .card-glass {
            padding: 1.25rem;
            border-radius: 10px;
        }

        .tab-btn {
            padding: 7px 14px;
            font-size: 12px;
            height: 36px;
        }

        .tab-btn i {
            margin-right: 5px;
            font-size: 13px;
        }

        .btn-gradient {
            padding: 9px 18px;
            font-size: 12px;
        }

        .tab-text {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .card-glass {
            padding: 1rem;
        }

        .tab-btn {
            padding: 6px 12px;
            font-size: 11px;
            height: 34px;
        }

        .tab-btn i {
            margin-right: 4px;
            font-size: 12px;
        }

        .tab-text {
            font-size: 11px;
        }

        .flex-row.space-x-2 {
            gap: 4px;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tab-content.active {
        animation: fadeInUp 0.3s ease-out;
    }

    .tab-btn:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    .btn-gradient:focus {
        outline: 2px solid white;
        outline-offset: 2px;
    }

    /* Layout konsisten */
    .flex-row {
        flex-direction: row !important;
    }

    .justify-center {
        justify-content: center !important;
    }

    .items-center {
        align-items: center !important;
    }

    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .overflow-x-auto::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection 