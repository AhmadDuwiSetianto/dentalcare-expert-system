<div>
    @if($diagnoses->count() > 0)
        <div class="space-y-4">
            @foreach($diagnoses as $diagnosis)
            
            {{-- LOGIKA PERBAIKAN: Hitung jumlah gejala dengan aman --}}
            @php
                $symptomCount = 0;
                $symptoms = $diagnosis->symptoms_checked;
                
                // Jika data berupa string (JSON), decode dulu
                if (is_string($symptoms)) {
                    $decoded = json_decode($symptoms, true);
                    if (is_array($decoded)) {
                        $symptomCount = count($decoded);
                    }
                } 
                // Jika sudah array, langsung hitung
                elseif (is_array($symptoms)) {
                    $symptomCount = count($symptoms);
                }
            @endphp

            <div class="card-glass hover:transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h3 class="text-lg font-semibold text-white mr-3">{{ $diagnosis->disease_name }}</h3>
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    @if($diagnosis->confidence_level >= 80) bg-green-500/20 text-green-400
                                    @elseif($diagnosis->confidence_level >= 60) bg-yellow-500/20 text-yellow-400
                                    @else bg-red-500/20 text-red-400 @endif">
                                {{ $diagnosis->confidence_level }}% Keyakinan
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap gap-4 text-sm text-gray-300 mb-3">
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2 text-blue-400"></i>
                                <span>{{ $diagnosis->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-list mr-2 text-green-400"></i>
                                {{-- Menggunakan variabel yang sudah dihitung di atas --}}
                                <span>{{ $symptomCount }} gejala diperiksa</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-400 text-sm">{{ $diagnosis->recommendation }}</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 md:ml-4 flex space-x-2">
                        <a href="{{ route('diagnosis.pdf.download', $diagnosis->id) }}" class="btn-secondary text-sm px-4 py-2 flex items-center">
                            <i class="fas fa-file-pdf mr-1"></i> PDF
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-history text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-300 mb-2">Belum Ada Riwayat</h3>
            <p class="text-gray-400 mb-6">Anda belum melakukan diagnosa apapun</p>
            <button type="button" onclick="startDiagnosis()" class="btn-gradient">
                <i class="fas fa-stethoscope mr-2"></i>Mulai Diagnosa Pertama
            </button>
        </div>
    @endif
</div>

<script>
function showDiagnosisDetail(diagnosisId) {
    // You can implement a modal or redirect to detail page
    alert('Detail diagnosa ID: ' + diagnosisId + '\nFitur detail akan segera tersedia.');
}
</script>