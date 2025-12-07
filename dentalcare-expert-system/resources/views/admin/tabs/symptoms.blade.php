<div class="symptoms-content">
    <div class="table-container">
        <div class="table-header">
            <h3 class="text-lg font-semibold">Symptom Management</h3>
            <button class="btn btn-primary" onclick="showSymptomModal()">
                <i class="fas fa-plus"></i> Add Symptom
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table" style="table-layout: fixed; width: 100%;">
                <colgroup>
                    <col style="width: 7%">
                    <col style="width: 38%">
                    <col style="width: 10%">
                    <col style="width: 6%">
                    <col style="width: 10%">
                    <col style="width: 9%">
                    <col style="width: 10%">
                    <col style="width: 10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Diseases</th>
                        <th>Created</th>
                        <th style="min-width: 85px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($symptoms as $symptom)
                    <tr>
                        <td>
                            <span class="font-mono font-bold text-blue-400">{{ $symptom->code }}</span>
                        </td>
                        <td class="max-w-md">
                            <div class="question-text">
                                {{ $symptom->question }}
                            </div>
                            @if($symptom->options)
                                <div class="mt-1">
                                    @php
                                        $options = is_array($symptom->options) ? $symptom->options : json_decode($symptom->options, true);
                                    @endphp
                                    @if($options && is_array($options))
                                        @foreach($options as $key => $value)
                                        <span class="inline-block px-2 py-1 text-xs bg-gray-600 rounded mr-1 mb-1">
                                            {{ $key }}: {{ $value }}
                                        </span>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs capitalize 
                                {{ $symptom->type === 'yes_no' ? 'bg-green-500/20 text-green-400' : 
                                   ($symptom->type === 'multiple_choice' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400') }}">
                                {{ str_replace('_', ' ', $symptom->type) }}
                            </span>
                        </td>
                        <td>
                            <span class="font-mono font-bold">{{ $symptom->order }}</span>
                        </td>
                        <td>
                            @if($symptom->is_active)
                                <span class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400 border border-green-500/30">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-400 border border-red-500/30">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs bg-gray-500/20 text-gray-400">
                                {{ $symptom->diseases_count }}
                            </span>
                        </td>
                        <td>
                            <div class="text-sm">
                                @php
                                    $indonesiaTime = $symptom->created_at->copy()->setTimezone('Asia/Jakarta');
                                @endphp
                                <div>{{ $indonesiaTime->format('M d, Y') }}</div>
                                <div class="text-gray-400">{{ $indonesiaTime->format('H:i') }}</div>
                            </div>
                        </td>
                        <td style="min-width: 85px;">
                            <div style="display: flex; gap: 2px; flex-wrap: nowrap; white-space: nowrap;">
                                <button class="btn btn-primary btn-sm" onclick="editSymptom({{ $symptom->id }})" style="padding: 2px 6px; min-width: 30px; height: 24px;">
                                    <i class="fas fa-edit" style="font-size: 10px;"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteSymptom({{ $symptom->id }})" style="padding: 2px 6px; min-width: 30px; height: 24px;">
                                    <i class="fas fa-trash" style="font-size: 10px;"></i>
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