<div class="dashboard-content">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon stat-diagnoses">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-number">{{ $stats['total_diagnoses'] }}</div>
            <div class="stat-label">Total Diagnoses</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon stat-diseases">
                <i class="fas fa-disease"></i>
            </div>
            <div class="stat-number">{{ $stats['total_diseases'] }}</div>
            <div class="stat-label">Total Diseases</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon stat-symptoms">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="stat-number">{{ $stats['total_symptoms'] }}</div>
            <div class="stat-label">Total Symptoms</div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Recent Diagnoses -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="text-lg font-semibold">Recent Diagnoses</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Disease</th>
                            <th>Confidence</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_diagnoses'] as $diagnosis)
                        <tr>
                            <td>{{ $diagnosis->user->name }}</td>
                            <td>{{ $diagnosis->disease_name }}</td>
                            <td>
                                <span class="px-2 py-1 rounded-full text-xs {{ $diagnosis->confidence_level >= 70 ? 'bg-green-500/20 text-green-400' : ($diagnosis->confidence_level >= 50 ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                                    {{ $diagnosis->confidence_level }}%
                                </span>
                            </td>
                            <td>{{ $diagnosis->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popular Diseases -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="text-lg font-semibold">Popular Diseases</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Disease</th>
                            <th>Diagnosis Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['popular_diseases'] as $disease)
                        <tr>
                            <td>{{ $disease->disease_name }}</td>
                            <td>{{ $disease->count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>