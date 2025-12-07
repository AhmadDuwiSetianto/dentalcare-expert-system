<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold gradient-text mb-2">Informasi Penyakit Gigi & Mulut</h2>
        <p class="text-gray-300">Pelajari tentang berbagai penyakit gigi dan mulut beserta penanganannya</p>
    </div>

    @if($diseases->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($diseases as $disease)
            <div class="card-glass hover:transform hover:scale-[1.02] transition-all duration-300 cursor-pointer"
                 onclick="showDiseaseDetail(<?php echo $disease->id; ?>)">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 rounded-full 
                                @if($disease->severity === 'high') bg-red-500/20 text-red-400
                                @elseif($disease->severity === 'medium') bg-yellow-500/20 text-yellow-400
                                @else bg-green-500/20 text-green-400 @endif
                                flex items-center justify-center mr-3">
                        <i class="fas fa-tooth"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-white mb-1">{{ $disease->name }}</h3>
                        <div class="flex items-center text-sm">
                            <span class="px-2 py-1 rounded-full text-xs
                                        @if($disease->severity === 'high') bg-red-500/20 text-red-400
                                        @elseif($disease->severity === 'medium') bg-yellow-500/20 text-yellow-400
                                        @else bg-green-500/20 text-green-400 @endif">
                                @if($disease->severity === 'high') Berat
                                @elseif($disease->severity === 'medium') Sedang
                                @else Ringan @endif
                            </span>
                            @if($disease->is_emergency)
                            <span class="ml-2 px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-400">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Darurat
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <p class="text-gray-300 text-sm line-clamp-2 mb-4">
                    {{ Str::limit(strip_tags($disease->description), 100) }}
                </p>
                
                <div class="flex items-center justify-between text-xs text-gray-400">
                    <span>{{ Str::limit(strip_tags($disease->treatment), 50) }}</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            @endforeach
        </div>
        
        <div id="disease-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-gray-900 rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div id="disease-modal-content">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-info-circle text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-400">Data penyakit belum tersedia</p>
        </div>
    @endif
</div>

<script>
function showDiseaseDetail(diseaseId) {
    fetch('/diagnosis/disease/' + diseaseId)
        .then(function(response) {
            return response.json();
        })
        .then(function(disease) {
            var modal = document.getElementById('disease-modal');
            var content = document.getElementById('disease-modal-content');
            
            var symptomsHtml = '';
            if (disease.symptoms && Array.isArray(disease.symptoms)) {
                disease.symptoms.forEach(function(symptom) {
                    var symptomText = symptom.question || symptom.code || 'Gejala tidak tersedia';
                    symptomsHtml += '<div class="flex items-center mb-2"><i class="fas fa-circle text-xs text-blue-400 mr-3"></i><span class="text-gray-300">' + symptomText + '</span></div>';
                });
            }
            
            var causesHtml = '';
            if (disease.causes) {
                causesHtml = '<div><h4 class="text-lg font-semibold mb-3 text-white">Penyebab</h4><p class="text-gray-300">' + disease.causes + '</p></div>';
            }
            
            var riskFactorsHtml = '';
            if (disease.risk_factors) {
                riskFactorsHtml = '<div><h4 class="text-lg font-semibold mb-3 text-white">Faktor Risiko</h4><p class="text-gray-300">' + disease.risk_factors + '</p></div>';
            }
            
            content.innerHTML = '<div class="p-6">' +
                '<div class="flex justify-between items-start mb-6">' +
                    '<h3 class="text-2xl font-bold gradient-text">' + disease.name + '</h3>' +
                    '<button type="button" onclick="closeDiseaseModal()" class="text-gray-400 hover:text-white">' +
                        '<i class="fas fa-times text-xl"></i>' +
                    '</button>' +
                '</div>' +
                '<div class="space-y-6">' +
                    '<div>' +
                        '<h4 class="text-lg font-semibold mb-3 text-white">Deskripsi</h4>' +
                        '<p class="text-gray-300">' + disease.description + '</p>' +
                    '</div>' +
                    '<div>' +
                        '<h4 class="text-lg font-semibold mb-3 text-white">Gejala</h4>' +
                        '<div class="bg-white/5 rounded-lg p-4">' + symptomsHtml + '</div>' +
                    '</div>' +
                    '<div class="grid md:grid-cols-2 gap-6">' +
                        '<div>' +
                            '<h4 class="text-lg font-semibold mb-3 text-white">Pengobatan</h4>' +
                            '<p class="text-gray-300">' + disease.treatment + '</p>' +
                        '</div>' +
                        '<div>' +
                            '<h4 class="text-lg font-semibold mb-3 text-white">Pencegahan</h4>' +
                            '<p class="text-gray-300">' + disease.prevention + '</p>' +
                        '</div>' +
                    '</div>' +
                    causesHtml +
                    riskFactorsHtml +
                '</div>' +
                '<div class="mt-8 pt-6 border-t border-white/10">' +
                    '<button type="button" onclick="closeDiseaseModal()" class="btn-gradient w-full">' +
                        '<i class="fas fa-times mr-2"></i>Tutup' +
                    '</button>' +
                '</div>' +
            '</div>';
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(function(error) {
            console.error('Error loading disease detail:', error);
            alert('Error memuat detail penyakit');
        });
}

function closeDiseaseModal() {
    var modal = document.getElementById('disease-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('disease-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDiseaseModal();
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    /* -webkit-line-clamp: 2; */
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>