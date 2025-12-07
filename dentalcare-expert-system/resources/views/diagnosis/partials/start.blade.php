<div class="diagnosis-start-content">
    <div class="text-center py-4">
        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
            <i class="fas fa-stethoscope text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-3">Mulai Diagnosa</h3>
        <p class="text-gray-300 text-base mb-6 max-w-md mx-auto leading-relaxed">
            Jawab beberapa pertanyaan untuk mendapatkan diagnosis awal masalah gigi dan mulut Anda. Sistem akan menganalisis gejala yang Anda alami.
        </p>
        
        <div class="max-w-md mx-auto bg-gray-700/50 rounded-lg p-6 mb-6">
            <h4 class="text-white font-semibold mb-3">Persiapan Diagnosa:</h4>
            <ul class="text-gray-300 text-sm text-left space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mt-1 mr-3 flex-shrink-0"></i>
                    <span>Siapkan informasi tentang gejala yang dialami</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mt-1 mr-3 flex-shrink-0"></i>
                    <span>Waktu yang dibutuhkan: 3-5 menit</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-400 mt-1 mr-3 flex-shrink-0"></i>
                    <span>Jawab dengan jujur untuk hasil yang akurat</span>
                </li>
            </ul>
        </div>

        <button type="button" id="startDiagnosisBtn" class="btn-gradient text-lg px-8 py-4">
            <i class="fas fa-play mr-3"></i>
            <span>Mulai Diagnosa Sekarang</span>
        </button>
        
        <p class="text-gray-400 text-sm mt-6 max-w-md mx-auto">
            <i class="fas fa-info-circle mr-2"></i>
            Hasil diagnosis bersifat prediktif dan tidak menggantikan konsultasi dengan dokter gigi
        </p>
    </div>

    <script>
    function startDiagnosis() {
        console.log('🚀 Starting diagnosis process...');
        
        // Create diagnosis container
        const startContent = document.querySelector('.diagnosis-start-content');
        startContent.innerHTML = `
            <div class="diagnosis-container">
                <div class="diagnosis-card">
                    <h2 class="diagnosis-title">Diagnosa Penyakit Gigi</h2>
                    <p class="diagnosis-subtitle">Jawab pertanyaan berikut untuk mendapatkan diagnosis</p>

                    <!-- Progress Bar -->
                    <div class="progress-container mb-6">
                        <div class="progress-bar">
                            <div class="progress-fill" id="progressFill" style="width: 0%"></div>
                        </div>
                        <div class="progress-text text-center mt-2">
                            <span id="progressText">0%</span> Selesai
                        </div>
                    </div>

                    <!-- Question Container -->
                    <div id="questionContainer">
                        <div class="text-center py-8">
                            <div class="spinner"></div>
                            <p class="text-gray-400 mt-4">Memuat pertanyaan pertama...</p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="navigation-buttons mt-8 flex justify-between" id="navButtons" style="display: none;">
                        <button type="button" id="prevBtn" class="btn-secondary" disabled>
                            <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
                        </button>
                        <button type="button" id="nextBtn" class="btn-primary">
                            Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Initialize diagnosis process
        initializeDiagnosisProcess();
    }

    function initializeDiagnosisProcess() {
        // Global variables
        window.currentStep = 1;
        window.answers = {};
        window.totalQuestions = 0;

        // Load first question
        loadQuestion(window.currentStep);

        // Navigation buttons event listeners
        document.getElementById('nextBtn').addEventListener('click', function() {
            const selectedAnswer = document.querySelector('.answer-btn.border-blue-500');

            if (!selectedAnswer) {
                showMessage('Silakan pilih jawaban terlebih dahulu', 'warning');
                return;
            }

            // Save answer
            answers['q' + currentStep] = selectedAnswer.getAttribute('data-value');
            console.log('Answer saved:', answers);

            // Process to next question
            processAnswer();
        });

        document.getElementById('prevBtn').addEventListener('click', function() {
            if (currentStep > 1) {
                // Remove last answer
                delete answers['q' + (currentStep - 1)];
                console.log('Going back to step:', currentStep - 1);
                loadQuestion(currentStep - 1);
            }
        });
    }

    function loadQuestion(step) {
        console.log('Loading question for step: ' + step);
        showLoading();

        const requestBody = {
            step: step,
            answers: answers
        };

        fetch('/diagnosis/question', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                if (data.completed) {
                    console.log('Diagnosis completed');
                    showResult(data.result);
                } else {
                    console.log('Question loaded successfully');
                    displayQuestion(data.question, data.step, data.progress);
                }
            } else {
                console.error('Server error:', data.message);
                showError(data.message || 'Terjadi kesalahan server');
            }
        })
        .catch(error => {
            console.error('Network error:', error);
            showError('Terjadi kesalahan jaringan: ' + error.message);
        });
    }

    function displayQuestion(question, step, progress) {
        console.log('Displaying question:', question);

        const questionContainer = document.getElementById('questionContainer');
        const navButtons = document.getElementById('navButtons');

        if (!question) {
            showError('Pertanyaan tidak ditemukan');
            return;
        }

        let questionHtml = '<div class="question-content">' +
            '<h3 class="question-text text-lg font-semibold mb-6 text-white">' + question.text + '</h3>' +
            '<div class="answer-options space-y-3">';

        if (question.type === 'yes_no') {
            questionHtml += 
                '<button type="button" class="answer-btn w-full text-left p-4 border border-gray-600 rounded-lg hover:border-blue-500 transition-colors text-white" data-value="yes">' +
                    '<i class="fas fa-check-circle mr-3 text-green-500"></i>Ya' +
                '</button>' +
                '<button type="button" class="answer-btn w-full text-left p-4 border border-gray-600 rounded-lg hover:border-blue-500 transition-colors text-white" data-value="no">' +
                    '<i class="fas fa-times-circle mr-3 text-red-500"></i>Tidak' +
                '</button>';
        } else if (question.type === 'multiple_choice' && question.options) {
            for (const [value, text] of Object.entries(question.options)) {
                questionHtml += 
                    '<button type="button" class="answer-btn w-full text-left p-4 border border-gray-600 rounded-lg hover:border-blue-500 transition-colors text-white" data-value="' + value + '">' +
                        '<i class="far fa-circle mr-3 text-gray-400"></i>' + text +
                    '</button>';
            }
        }

        questionHtml += '</div></div>';

        questionContainer.innerHTML = questionHtml;
        navButtons.style.display = 'flex';

        // Update progress
        updateProgress(progress);

        // Add event listeners to answer buttons
        const answerButtons = document.querySelectorAll('.answer-btn');
        answerButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                answerButtons.forEach(b => {
                    b.classList.remove('border-blue-500', 'bg-blue-500/10');
                    const icon = b.querySelector('i');
                    if (question.type === 'yes_no') {
                        if (b.getAttribute('data-value') === 'yes') {
                            icon.className = 'fas fa-check-circle mr-3 text-green-500';
                        } else {
                            icon.className = 'fas fa-times-circle mr-3 text-red-500';
                        }
                    } else {
                        icon.className = 'far fa-circle mr-3 text-gray-400';
                    }
                });

                // Add active class to clicked button
                this.classList.add('border-blue-500', 'bg-blue-500/10');

                if (question.type === 'yes_no') {
                    const icon = this.querySelector('i');
                    if (this.getAttribute('data-value') === 'yes') {
                        icon.className = 'fas fa-check-circle mr-3 text-green-500';
                    } else {
                        icon.className = 'fas fa-times-circle mr-3 text-red-500';
                    }
                } else {
                    this.querySelector('i').className = 'fas fa-check-circle mr-3 text-green-500';
                }

                // Enable next button
                document.getElementById('nextBtn').disabled = false;
                console.log('Answer selected:', this.getAttribute('data-value'));
            });
        });

        // Update navigation buttons
        document.getElementById('prevBtn').disabled = step === 1;
        document.getElementById('nextBtn').disabled = true;

        currentStep = step;
        console.log('Question displayed successfully');
    }

    function processAnswer() {
        console.log('Processing answer for step:', currentStep);
        showLoading();

        const requestBody = {
            step: currentStep,
            answers: answers,
            answer: answers['q' + currentStep]
        };

        fetch('/diagnosis/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Process response data:', data);
            
            if (data.success) {
                if (data.completed) {
                    console.log('All questions completed');
                    showResult(data.result);
                } else {
                    console.log('Loading next question');
                    displayQuestion(data.question, data.step, data.progress);
                }
            } else {
                console.error('Process error:', data.message);
                showError(data.message || 'Terjadi kesalahan saat memproses jawaban');
            }
        })
        .catch(error => {
            console.error('Process network error:', error);
            showError('Terjadi kesalahan jaringan: ' + error.message);
        });
    }

    function showResult(result) {
        console.log('Showing result:', result);
        
        // Save result to localStorage for result tab
        localStorage.setItem('latestDiagnosis', JSON.stringify(result));
        
        // Show result in current tab
        const questionContainer = document.getElementById('questionContainer');
        const navButtons = document.getElementById('navButtons');
        
        let emergencyClass = result.is_emergency ? 'border-red-500 bg-red-500/10' : 'border-green-500 bg-green-500/10';
        let emergencyIcon = result.is_emergency ? 'fas fa-exclamation-triangle text-red-500' : 'fas fa-check-circle text-green-500';
        let emergencyText = result.is_emergency ? 'Kondisi Darurat' : 'Kondisi Normal';

        questionContainer.innerHTML = `
            <div class="result-content text-center">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full ${emergencyClass} flex items-center justify-center border-4">
                    <i class="${emergencyIcon} text-3xl"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-white mb-4">${result.name}</h3>
                
                <div class="confidence-level mb-6">
                    <div class="text-sm text-gray-300 mb-2">Tingkat Kecocokan</div>
                    <div class="w-full bg-gray-700 rounded-full h-4 mb-2">
                        <div class="bg-gradient-to-r from-green-400 to-blue-500 h-4 rounded-full" style="width: ${result.confidence}%"></div>
                    </div>
                    <div class="text-lg font-bold text-white">${result.confidence}%</div>
                </div>

                <div class="result-details text-left bg-gray-700/50 rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-white mb-3">Deskripsi</h4>
                            <p class="text-gray-300 text-sm">${result.description}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-3">Penanganan</h4>
                            <p class="text-gray-300 text-sm">${result.treatment}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-3">Pencegahan</h4>
                            <p class="text-gray-300 text-sm">${result.prevention}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-3">Rekomendasi</h4>
                            <p class="text-gray-300 text-sm">${result.recommendation}</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="location.reload()" class="btn-secondary">
                        <i class="fas fa-redo mr-2"></i>Diagnosa Ulang
                    </button>
                    <button type="button" onclick="switchToResultTab()" class="btn-primary">
                        <i class="fas fa-chart-line mr-2"></i>Lihat Detail Hasil
                    </button>
                </div>
            </div>
        `;
        
        navButtons.style.display = 'none';
    }

    function switchToResultTab() {
        // Switch to result tab
        const resultTabBtn = document.querySelector('[data-tab="result"]');
        if (resultTabBtn) {
            resultTabBtn.click();
        }
    }

    // Helper functions
    function updateProgress(percent) {
        document.getElementById('progressFill').style.width = percent + '%';
        document.getElementById('progressText').textContent = Math.round(percent) + '%';
    }

    function showLoading() {
        document.getElementById('questionContainer').innerHTML = 
            '<div class="text-center py-8">' +
                '<div class="spinner"></div>' +
                '<p class="text-gray-400 mt-4">Memuat pertanyaan...</p>' +
            '</div>';
        document.getElementById('navButtons').style.display = 'none';
    }

    function showError(message) {
        document.getElementById('questionContainer').innerHTML = 
            '<div class="text-center py-8 text-red-400">' +
                '<i class="fas fa-exclamation-triangle text-3xl mb-3"></i>' +
                '<p class="mb-4">' + message + '</p>' +
                '<button type="button" onclick="loadQuestion(currentStep)" class="btn-primary mt-4">' +
                    '<i class="fas fa-redo mr-2"></i>Coba Lagi' +
                '</button>' +
            '</div>';
        document.getElementById('navButtons').style.display = 'none';
    }

    function showMessage(message, type = 'info') {
        // Create toast message
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 p-4 rounded-lg text-white ${
            type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
        } z-50`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Add event listener to start button
    document.addEventListener('DOMContentLoaded', function() {
        const startBtn = document.getElementById('startDiagnosisBtn');
        if (startBtn) {
            startBtn.addEventListener('click', startDiagnosis);
        }
    });
    </script>

    <style>
    .diagnosis-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .diagnosis-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
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
    }

    .btn-secondary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .answer-btn {
        transition: all 0.3s ease;
    }

    .answer-btn:hover {
        transform: translateY(-2px);
    }

    .result-content {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
    </div>