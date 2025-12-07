<div class="diseases-content">
    <div class="table-container">
        <div class="table-header">
            <h3 class="text-lg font-semibold">Disease Management</h3>
            <button class="btn btn-primary" onclick="showDiseaseModal()">
                <i class="fas fa-plus"></i> Add Disease
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Severity</th>
                        <th>Emergency</th>
                        <th>Symptoms</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diseases as $disease)
                    <tr>
                        <td class="font-semibold">{{ $disease->name }}</td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs capitalize 
                                {{ $disease->severity === 'high' ? 'bg-red-500/20 text-red-400' : 
                                   ($disease->severity === 'medium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }}">
                                {{ $disease->severity }}
                            </span>
                        </td>
                        <td>
                            @if($disease->is_emergency)
                                <span class="px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-400">
                                    <i class="fas fa-exclamation-triangle"></i> Emergency
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td>{{ $disease->symptoms_count }}</td>
                        <td>{{ $disease->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex gap-2">
                                <button class="btn btn-primary btn-sm" onclick="editDisease({{ $disease->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteDisease({{ $disease->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function showDiseaseModal() {
    // Implementation for disease modal
    alert('Add disease functionality');
}

function editDisease(diseaseId) {
    // Implementation for edit disease
    alert('Edit disease: ' + diseaseId);
}

function deleteDisease(diseaseId) {
    if (confirm('Are you sure you want to delete this disease?')) {
        fetch(`/admin/diseases/${diseaseId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>