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
        <div class="navigation-buttons mt-8" id="navButtons" style="display: none;">
            <div class="button-container">
                <button type="button" id="prevBtn" class="btn-secondary" disabled>
                    <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
                </button>
                <button type="button" id="nextBtn" class="btn-primary" disabled>
                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.diagnosis-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.diagnosis-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 24px;
    margin-bottom: 20px;
}

.diagnosis-title {
    font-size: 24px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    text-align: center;
}

.diagnosis-subtitle {
    color: #718096;
    text-align: center;
    margin-bottom: 24px;
}

.progress-container {
    width: 100%;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background-color: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background-color: #4299e1;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 14px;
    color: #718096;
}

#questionContainer {
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #4299e1;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.navigation-buttons {
    width: 100%;
}

.button-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
}

.btn-primary, .btn-secondary {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 48px;
}

.btn-primary {
    background-color: #4299e1;
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background-color: #3182ce;
}

.btn-secondary {
    background-color: #e2e8f0;
    color: #4a5568;
}

.btn-secondary:hover:not(:disabled) {
    background-color: #cbd5e0;
}

.btn-primary:disabled, .btn-secondary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive Design */
@media (min-width: 768px) {
    .diagnosis-card {
        padding: 32px;
    }
    
    .button-container {
        flex-direction: row;
        justify-content: space-between;
    }
    
    .btn-primary, .btn-secondary {
        width: 48%;
    }
}

@media (max-width: 767px) {
    .diagnosis-container {
        padding: 16px;
    }
    
    .diagnosis-card {
        padding: 20px;
    }
    
    .diagnosis-title {
        font-size: 20px;
    }
    
    .btn-primary, .btn-secondary {
        font-size: 15px;
        padding: 14px 16px;
    }
}

@media (max-width: 480px) {
    .diagnosis-container {
        padding: 12px;
    }
    
    .diagnosis-card {
        padding: 16px;
    }
    
    .diagnosis-title {
        font-size: 18px;
    }
    
    .btn-primary, .btn-secondary {
        font-size: 14px;
        padding: 12px 14px;
    }
}
</style>