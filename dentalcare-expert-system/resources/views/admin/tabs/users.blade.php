<div class="users-content">
    <div class="table-container">
        <div class="table-header">
            <h3 class="text-lg font-semibold">User Management</h3>
            <button class="btn btn-primary" onclick="exportUsers()">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 8%;">Age</th>
                        <th style="width: 10%;">Gender</th>
                        <th style="width: 12%;">Role</th>
                        <th style="width: 10%;">Diagnoses</th>
                        <th style="width: 12%;">Registered</th>
                        <th style="width: 13%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="font-semibold" style="width: 15%;">{{ $user->name }}</td>
                        <td style="width: 20%;">{{ $user->email }}</td>
                        <td style="width: 8%;">{{ $user->age ?? '-' }}</td>
                        <td style="width: 10%;">
                            @if($user->gender)
                                <span class="capitalize">{{ $user->gender }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td style="width: 12%;">
                            @if($user->is_admin)
                                <span class="px-2 py-1 rounded-full text-xs bg-purple-500/20 text-purple-400">Admin</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400">User</span>
                            @endif
                        </td>
                        <td style="width: 10%;">{{ $user->diagnoses_count }}</td>
                        <td style="width: 12%;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="width: 13%; min-width: 100px;">
                            <div class="flex gap-1 justify-start">
                                <button class="btn btn-primary btn-sm" onclick="editUser({{ $user->id }})" style="padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($user->email !== 'admin@dentalcare.com' && !$user->is_admin)
                                <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})" style="padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>