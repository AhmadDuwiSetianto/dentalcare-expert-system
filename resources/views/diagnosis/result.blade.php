<div class="result-container">
    @if($latestDiagnosis)
    <div class="result-card success">
        <div class="result-header">
            @if($latestDiagnosis->confidence_level >= 70)
                <i class="fas fa-check-circle text-green-400 text-4xl mb-4"></i>
            @elseif($latestDiagnosis->confidence_level >= 50)
                <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-4"></i>
            @else
                <i class="fas fa-info-circle text-blue-400 text-4xl mb-4"></i>
            @endif
            <h3 class="result-title">Diagnosis Selesai</h3>
            <p class="result-subtitle">Berikut adalah hasil diagnosis Anda</p>
        </div>

        <div class="result-content">
            <div class="result-item">
                <label>Penyakit Terdiagnosis:</label>
                <span class="font-bold text-white">{{ $latestDiagnosis->disease_name }}</span>
            </div>

            <div class="result-item">
                <label>Tingkat Keyakinan:</label>
                <span class="confidence-badge confidence-{{ 
                    $latestDiagnosis->confidence_level >= 70 ? 'high' : 
                    ($latestDiagnosis->confidence_level >= 50 ? 'medium' : 'low') 
                }}">
                    {{ $latestDiagnosis->confidence_level }}%
                </span>
            </div>

            @if($latestDiagnosis->disease_description)
            <div class="result-item">
                <label>Deskripsi:</label>
                <span class="text-gray-300">{{ $latestDiagnosis->disease_description }}</span>
            </div>
            @endif

            @if($latestDiagnosis->treatment)
            <div class="result-item">
                <label>Perawatan:</label>
                <span class="text-gray-300">{{ $latestDiagnosis->treatment }}</span>
            </div>
            @endif

            @if($latestDiagnosis->prevention)
            <div class="result-item">
                <label>Pencegahan:</label>
                <span class="text-gray-300">{{ $latestDiagnosis->prevention }}</span>
            </div>
            @endif

            <div class="result-item">
                <label>Rekomendasi:</label>
                <span class="text-gray-300">{{ $latestDiagnosis->recommendation }}</span>
            </div>

            <div class="result-item">
                <label>Status Darurat:</label>
                <span class="emergency-badge {{ $latestDiagnosis->is_emergency ? 'emergency-yes' : 'emergency-no' }}">
                    {{ $latestDiagnosis->is_emergency ? 'Darurat' : 'Tidak Darurat' }}
                </span>
            </div>

            <div class="result-item">
                <label>Metode Diagnosa:</label>
                <span class="text-gray-300">{{ $latestDiagnosis->inference_method }}</span>
            </div>

            <div class="result-item">
                <label>Gejala yang Cocok:</label>
                <span class="text-gray-300">{{ $latestDiagnosis->matched_symptoms_count }} gejala</span>
            </div>

            <div class="result-item">
                <label>Tanggal Diagnosa:</label>
                <span class="text-gray-300">
                    {{ $latestDiagnosis->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                </span>
            </div>
        </div>

        <div class="result-actions">
            <div class="button-group">
                <button type="button" class="btn-secondary" onclick="handleViewHistory()">
                    <i class="fas fa-history mr-2"></i>Lihat Riwayat
                </button>

                <button type="button" 
                        class="btn-secondary" 
                        id="downloadPdfBtn"
                        data-id="{{ $latestDiagnosis->id ?? '' }}"
                        onclick="downloadPDF(this)">
                    <i class="fas fa-file-pdf mr-2"></i>Download PDF
                </button>

                <button type="button" class="btn-gradient" onclick="handleNewDiagnosis()">
                    <i class="fas fa-redo mr-2"></i>Diagnosa Baru
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="result-card empty">
        <div class="result-header">
            <i class="fas fa-stethoscope text-blue-400 text-4xl mb-4"></i>
            <h3 class="result-title">Belum Ada Hasil Diagnosa</h3>
            <p class="result-subtitle">Silakan lakukan diagnosa terlebih dahulu</p>
        </div>

        <div class="result-actions">
            <button type="button" class="btn-gradient" onclick="startDiagnosis()">
                <i class="fas fa-play mr-2"></i>Mulai Diagnosa
            </button>
        </div>
    </div>
    @endif
</div>

<style>
    .result-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 0 16px;
    }

    .result-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }

    .result-header {
        margin-bottom: 2rem;
    }

    .result-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        margin-bottom: 0.5rem;
    }

    .result-subtitle {
        color: #9CA3AF;
        margin-bottom: 0;
    }

    .result-content {
        text-align: left;
        margin-bottom: 2rem;
    }

    .result-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .result-item label {
        font-weight: 600;
        color: #9CA3AF;
        min-width: 180px;
    }

    .result-item span {
        flex: 1;
        text-align: right;
    }

    .confidence-badge {
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .confidence-high {
        background: linear-gradient(135deg, #10B981, #059669);
    }

    .confidence-medium {
        background: linear-gradient(135deg, #F59E0B, #D97706);
    }

    .confidence-low {
        background: linear-gradient(135deg, #6B7280, #4B5563);
    }

    .emergency-badge {
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .emergency-yes {
        background: linear-gradient(135deg, #EF4444, #DC2626);
    }

    .emergency-no {
        background: linear-gradient(135deg, #10B981, #059669);
    }

    .result-actions {
        width: 100%;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
        height: 44px;
        flex: 1;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
        height: 44px;
        text-decoration: none;
        flex: 1;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
        color: white;
        text-decoration: none;
    }

    .btn-secondary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .result-container {
            padding: 0 12px;
        }

        .result-card {
            padding: 1.25rem;
            border-radius: 12px;
        }

        .result-title {
            font-size: 1.25rem;
        }

        .result-item {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .result-item label {
            min-width: auto;
            font-size: 0.9rem;
        }

        .result-item span {
            font-size: 0.95rem;
            text-align: left;
        }

        .button-group {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-gradient,
        .btn-secondary {
            width: 100%;
            min-width: auto;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
        }
    }
</style>