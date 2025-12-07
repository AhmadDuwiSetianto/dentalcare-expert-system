// public/js/diagnosis.js

// ✅ GLOBAL DIAGNOSIS FUNCTIONS
window.DiagnosisSystem = {
    currentStep: 1,
    answers: {},
    totalQuestions: 0,
    currentQuestionId: null,
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),

    // ✅ INITIALIZE DIAGNOSIS SYSTEM
    initialize: function() {
        console.log('🔄 Diagnosis system initializing...');
        
        // Reset state
        this.currentStep = 1;
        this.answers = {};
        this.totalQuestions = 0;
        this.currentQuestionId = null;
        
        // Load first question
        this.loadQuestion(this.currentStep);
        
        // Initialize navigation
        this.initializeNavigation();
    },

    // ✅ INITIALIZE NAVIGATION BUTTONS
    initializeNavigation: function() {
        console.log('🎯 Setting up navigation buttons...');
        
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        
        if (nextBtn && prevBtn) {
            // Remove existing event listeners by cloning
            nextBtn.replaceWith(nextBtn.cloneNode(true));
            prevBtn.replaceWith(prevBtn.cloneNode(true));
            
            // Get new references
            const newNextBtn = document.getElementById('nextBtn');
            const newPrevBtn = document.getElementById('prevBtn');
            
            // Add event listeners
            newNextBtn.addEventListener('click', () => this.handleNextButton());
            newPrevBtn.addEventListener('click', () => this.handlePrevButton());
            
            console.log('✅ Navigation buttons initialized');
        }
    },

    // ✅ HANDLE NEXT BUTTON
    handleNextButton: function() {
        console.log('➡️ Next button clicked');
        const selectedAnswer = document.querySelector('.answer-btn.border-blue-500');

        if (!selectedAnswer) {
            alert('Silakan pilih jawaban terlebih dahulu');
            return;
        }

        const answerValue = selectedAnswer.getAttribute('data-value');
        
        // Save answer
        this.answers['q' + this.currentQuestionId] = answerValue;
        console.log('💾 Answer saved:', this.answers);

        // Process to next question
        this.processAnswer(this.currentStep, answerValue);
    },

    // ✅ HANDLE PREVIOUS BUTTON
    handlePrevButton: function() {
        console.log('⬅️ Previous button clicked');
        if (this.currentStep > 1) {
            // Remove last answer
            const answerKeys = Object.keys(this.answers);
            if (answerKeys.length > 0) {
                const lastKey = answerKeys[answerKeys.length - 1];
                delete this.answers[lastKey];
                console.log('🗑️ Removed last answer:', lastKey);
            }
            
            console.log('↩️ Going back to step:', this.currentStep - 1);
            this.loadQuestion(this.currentStep - 1);
        }
    },

    // ✅ LOAD QUESTION
    loadQuestion: function(step) {
        console.log('📥 Loading question for step:', step);
        this.showLoading();

        const requestBody = {
            step: step,
            answers: this.answers
        };

        console.log('📤 Sending request to /diagnosis/question with:', requestBody);

        fetch('/diagnosis/question', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => {
            console.log('📥 Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Response data received:', data);
            
            if (data.success) {
                if (data.completed) {
                    console.log('🎉 Diagnosis completed');
                    this.showResult(data.result, data.diagnosis_id);
                } else {
                    console.log('📝 Question loaded successfully');
                    this.displayQuestion(data.question, data.step, data.progress);
                    this.totalQuestions = data.total_questions;
                }
            } else {
                console.error('❌ Server error:', data.message);
                this.showError(data.message || 'Terjadi kesalahan server');
            }
        })
        .catch(error => {
            console.error('❌ Network error:', error);
            this.showError('Terjadi kesalahan jaringan: ' + error.message);
        });
    },

    // ✅ PROCESS ANSWER
    processAnswer: function(step, answer) {
        console.log('🔄 Processing answer for step:', step, 'answer:', answer);
        this.showLoading();

        const requestBody = {
            step: step,
            answers: this.answers,
            answer: answer
        };

        console.log('📤 Sending process request to /diagnosis/process with:', requestBody);

        fetch('/diagnosis/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => {
            console.log('📥 Process response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Process response data:', data);
            
            if (data.success) {
                if (data.completed) {
                    console.log('🎉 All questions completed');
                    this.showResult(data.result, data.diagnosis_id);
                } else {
                    console.log('📝 Loading next question');
                    this.displayQuestion(data.question, data.step, data.progress);
                }
            } else {
                console.error('❌ Process error:', data.message);
                this.showError(data.message || 'Terjadi kesalahan saat memproses jawaban');
            }
        })
        .catch(error => {
            console.error('❌ Process network error:', error);
            this.showError('Terjadi kesalahan jaringan: ' + error.message);
        });
    },

    // ✅ DISPLAY QUESTION
    displayQuestion: function(question, step, progress) {
        console.log('🎨 Displaying question:', question);

        const questionContainer = document.getElementById('questionContainer');
        const navButtons = document.getElementById('navButtons');

        if (!question) {
            this.showError('Pertanyaan tidak ditemukan');
            return;
        }

        this.currentQuestionId = question.id;

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
        this.updateProgress(progress);

        // Add event listeners to answer buttons
        this.initializeAnswerButtons(question.type);
        
        // Update navigation buttons
        document.getElementById('prevBtn').disabled = step === 1;
        document.getElementById('nextBtn').disabled = true;

        this.currentStep = step;
        console.log('✅ Question displayed successfully - Step:', step);
    },

    // ✅ INITIALIZE ANSWER BUTTONS
    initializeAnswerButtons: function(questionType) {
        const answerButtons = document.querySelectorAll('.answer-btn');
        
        answerButtons.forEach(btn => {
            // Remove existing and add new event listener
            btn.replaceWith(btn.cloneNode(true));
        });

        const newAnswerButtons = document.querySelectorAll('.answer-btn');
        newAnswerButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                this.handleAnswerSelection(btn, questionType, newAnswerButtons);
            });
        });
    },

    // ✅ HANDLE ANSWER SELECTION
    handleAnswerSelection: function(selectedBtn, questionType, allButtons) {
        console.log('🎯 Answer selected:', selectedBtn.getAttribute('data-value'));
        
        // Remove active class from all buttons
        allButtons.forEach(b => {
            b.classList.remove('border-blue-500', 'bg-blue-500/10');
            const icon = b.querySelector('i');
            if (questionType === 'yes_no') {
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
        selectedBtn.classList.add('border-blue-500', 'bg-blue-500/10');

        if (questionType === 'yes_no') {
            const icon = selectedBtn.querySelector('i');
            if (selectedBtn.getAttribute('data-value') === 'yes') {
                icon.className = 'fas fa-check-circle mr-3 text-green-500';
            } else {
                icon.className = 'fas fa-times-circle mr-3 text-red-500';
            }
        } else {
            selectedBtn.querySelector('i').className = 'fas fa-check-circle mr-3 text-green-500';
        }

        // Enable next button
        document.getElementById('nextBtn').disabled = false;
        console.log('✅ Next button enabled');
    },

    // ✅ HELPER FUNCTIONS
    updateProgress: function(percent) {
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');
        
        if (progressFill && progressText) {
            progressFill.style.width = percent + '%';
            progressText.textContent = Math.round(percent) + '%';
            console.log('📊 Progress updated:', percent + '%');
        }
    },

    showLoading: function() {
        const questionContainer = document.getElementById('questionContainer');
        const navButtons = document.getElementById('navButtons');
        
        if (questionContainer) {
            questionContainer.innerHTML = 
                '<div class="text-center py-8">' +
                    '<div class="spinner"></div>' +
                    '<p class="text-gray-400 mt-4">Memuat pertanyaan...</p>' +
                '</div>';
        }
        
        if (navButtons) {
            navButtons.style.display = 'none';
        }
    },

    showError: function(message) {
        const questionContainer = document.getElementById('questionContainer');
        const navButtons = document.getElementById('navButtons');
        
        if (questionContainer) {
            questionContainer.innerHTML = 
                '<div class="text-center py-8 text-red-400">' +
                    '<i class="fas fa-exclamation-triangle text-3xl mb-3"></i>' +
                    '<p class="mb-4">' + message + '</p>' +
                    '<button type="button" onclick="DiagnosisSystem.loadQuestion(DiagnosisSystem.currentStep)" class="btn-primary mt-4">' +
                        '<i class="fas fa-redo mr-2"></i>Coba Lagi' +
                    '</button>' +
                '</div>';
        }
        
        if (navButtons) {
            navButtons.style.display = 'none';
        }
    },

    showResult: function(result, diagnosisId) {
        console.log('🎊 Showing result:', result);
        
        // Switch ke tab result menggunakan global function
        if (typeof window.loadTabContent === 'function') {
            console.log('🔄 Switching to result tab...');
            
            // Load result tab content
            window.loadTabContent('result', '/diagnosis/load/result');
            
            // Switch to result tab
            const resultTabBtn = document.querySelector('[data-tab="result"]');
            if (resultTabBtn) {
                resultTabBtn.click();
            }
        } else {
            console.error('❌ Global function loadTabContent not found');
            alert('Diagnosis completed! Check the Results tab.');
        }
    }
};