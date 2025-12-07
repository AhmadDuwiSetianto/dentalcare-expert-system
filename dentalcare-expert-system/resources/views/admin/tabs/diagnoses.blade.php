<div class="diagnoses-content">
    <div class="table-container">
        <div class="table-header">
            <h3 class="text-lg font-semibold">Diagnosis History</h3>
            <div class="flex gap-2">
                <button class="btn btn-primary" onclick="exportDiagnoses()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 18%;">User</th>
                        <th style="width: 18%;">Disease</th>
                        <th style="width: 15%;">Confidence</th>
                        <th style="width: 12%;">Emergency</th>
                        <th style="width: 12%;">Symptoms</th>
                        <th style="width: 12%;">Date</th>
                        <th style="width: 13%; min-width: 90px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diagnoses as $diagnosis)
                    <tr>
                        <td style="width: 18%;" class="font-semibold">
                                <span class="truncate">{{ $diagnosis->user->name }}</span>
                            </div>
                        </td>
                        <td style="width: 18%;">
                            <span class="font-medium truncate">{{ $diagnosis->disease_name }}</span>
                        </td>
                        <td style="width: 15%;">
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full" 
                                         style="width: {{ $diagnosis->confidence_level }}%"></div>
                                </div>
                                <span class="text-sm font-medium {{ $diagnosis->confidence_level >= 70 ? 'text-green-400' : ($diagnosis->confidence_level >= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                                    {{ $diagnosis->confidence_level }}%
                                </span>
                            </div>
                        </td>
                        <td style="width: 12%;">
                            @if($diagnosis->is_emergency)
                                <span class="px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-400 border border-red-500/30">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Emergency
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check mr-1"></i>Normal
                                </span>
                            @endif
                        </td>
                        <td style="width: 12%;">
                            <button class="btn btn-primary btn-sm" onclick="showSymptoms({{ $diagnosis->id }})" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                <i class="fas fa-eye mr-1"></i>({{ $diagnosis->symptoms_checked ? count(json_decode($diagnosis->symptoms_checked, true)) : 0 }})
                            </button>
                        </td>
                        <td style="width: 12%;">
                            <div class="text-sm">
                                @php
                                    // Convert to Indonesia time (UTC+7)
                                    $indonesiaTime = $diagnosis->created_at->copy()->setTimezone('Asia/Jakarta');
                                @endphp
                                <div>{{ $indonesiaTime->format('M d, Y') }}</div>
                                <div class="text-gray-400">{{ $indonesiaTime->format('H:i') }}</div>
                            </div>
                        </td>
                        <td style="width: 13%; min-width: 90px;">
                            <div class="flex gap-1 justify-start">
                                <button class="btn btn-primary btn-sm" onclick="viewDiagnosis({{ $diagnosis->id }})" style="padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteDiagnosis({{ $diagnosis->id }})" style="padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($diagnoses->hasPages())
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            {{ $diagnoses->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Symptoms Modal -->
<div id="symptomsModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Symptoms Checked</h3>
            <button class="modal-close" onclick="closeSymptomsModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="symptomsContent" class="modal-body space-y-3 max-h-96 overflow-y-auto">
            <!-- Symptoms content will be loaded here -->
        </div>
        <div class="modal-footer">
            <button onclick="closeSymptomsModal()" class="btn btn-secondary">Close</button>
        </div>
    </div>
</div>

<!-- Diagnosis Detail Modal -->
<div id="diagnosisModal" class="modal">
    <div class="modal-content" style="max-width: 700px;">
        <div class="modal-header">
            <h3 class="modal-title">Diagnosis Details</h3>
            <button class="modal-close" onclick="closeDiagnosisModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="diagnosisContent" class="modal-body">
            <!-- Diagnosis content will be loaded here -->
        </div>
        <div class="modal-footer">
            <button onclick="closeDiagnosisModal()" class="btn btn-secondary">Close</button>
        </div>
    </div>
</div>

<script>
// Show symptoms for a diagnosis
function showSymptoms(diagnosisId) {
    // Get diagnosis data from table row
    const row = document.querySelector(`tr:has(button[onclick="showSymptoms(${diagnosisId})"])`);
    if (!row) return;

    // Extract symptoms data from the diagnosis (you might need to store this data in data attributes)
    const symptomsCount = row.querySelector('button').textContent.match(/\((\d+)\)/)[1];
    
    // For now, we'll show a simple message. In real implementation, you'd fetch the actual symptoms
    const symptomsHtml = `
        <div class="text-center py-4">
            <i class="fas fa-stethoscope text-4xl text-blue-400 mb-3"></i>
            <p class="text-white font-medium">${symptomsCount} symptoms checked</p>
            <p class="text-gray-400 text-sm mt-2">Detailed symptoms data would be shown here</p>
        </div>
    `;

    document.getElementById('symptomsContent').innerHTML = symptomsHtml;
    document.getElementById('symptomsModal').classList.add('show');
}

// View diagnosis details
function viewDiagnosis(diagnosisId) {
    // Get diagnosis data from table row
    const row = document.querySelector(`tr:has(button[onclick="viewDiagnosis(${diagnosisId})"])`);
    if (!row) return;

    const cells = row.querySelectorAll('td');
    const userName = cells[0].querySelector('span').textContent;
    const diseaseName = cells[1].querySelector('span').textContent;
    const confidence = cells[2].querySelector('span').textContent;
    const isEmergency = cells[3].querySelector('span').textContent.includes('Emergency');
    const date = cells[5].querySelector('div').textContent;
    const time = cells[5].querySelector('.text-gray-400').textContent;

    const diagnosisHtml = `
        <div class="space-y-4">
            <!-- User Info -->
            <div class="card-glass p-4">
                <h4 class="font-semibold text-white mb-2">User Information</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400">Name:</span>
                        <div class="text-white">${userName}</div>
                    </div>
                </div>
            </div>

            <!-- Diagnosis Info -->
            <div class="card-glass p-4">
                <h4 class="font-semibold text-white mb-2">Diagnosis Information</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400">Disease:</span>
                        <div class="text-white font-medium">${diseaseName}</div>
                    </div>
                    <div>
                        <span class="text-gray-400">Confidence Level:</span>
                        <div class="text-white">${confidence}</div>
                    </div>
                    <div>
                        <span class="text-gray-400">Emergency:</span>
                        <div class="text-white">
                            ${isEmergency 
                                ? '<span class="px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-400">Yes</span>' 
                                : '<span class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400">No</span>'
                            }
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-400">Date:</span>
                        <div class="text-white">${date} ${time}</div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById('diagnosisContent').innerHTML = diagnosisHtml;
    document.getElementById('diagnosisModal').classList.add('show');
}

// Delete diagnosis
function deleteDiagnosis(diagnosisId) {
    if (confirm('Are you sure you want to delete this diagnosis record? This action cannot be undone.')) {
        fetch(`/admin/diagnoses/${diagnosisId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to delete diagnosis: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error deleting diagnosis: ' + error.message);
        });
    }
}

// Close modals
function closeSymptomsModal() {
    document.getElementById('symptomsModal').classList.remove('show');
}

function closeDiagnosisModal() {
    document.getElementById('diagnosisModal').classList.remove('show');
}

function exportDiagnoses() {
    window.open('/admin/diagnoses/export', '_blank');
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const symptomsModal = document.getElementById('symptomsModal');
    const diagnosisModal = document.getElementById('diagnosisModal');
    
    if (event.target === symptomsModal) {
        closeSymptomsModal();
    }
    if (event.target === diagnosisModal) {
        closeDiagnosisModal();
    }
});

// Close modals with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSymptomsModal();
        closeDiagnosisModal();
    }
});
</script>