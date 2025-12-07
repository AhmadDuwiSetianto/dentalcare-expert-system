<div class="settings-content">
    <div class="grid gap-6">
        <!-- Theme Settings -->
        <div class="card-glass p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Theme Settings</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-white">Current Theme</h4>
                        <p class="text-gray-300 text-sm">Choose your preferred theme</p>
                    </div>
                    <div class="theme-toggle">
                        <button class="theme-btn" id="settingsThemeToggle">
                            <i class="fas fa-palette"></i>
                            <span id="settingsCurrentTheme">Dark</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="theme-dropdown" id="settingsThemeDropdown">
                            <div class="theme-option" data-theme="light">
                                <i class="fas fa-sun"></i> Light
                            </div>
                            <div class="theme-option" data-theme="dark">
                                <i class="fas fa-moon"></i> Dark
                            </div>
                            <div class="theme-option" data-theme="system">
                                <i class="fas fa-desktop"></i> System
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="card-glass p-6">
            <h3 class="text-xl font-semibold text-white mb-4">System Information</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-white mb-2">Application</h4>
                    <div class="space-y-2 text-sm text-gray-300">
                        <div class="flex justify-between">
                            <span>Version:</span>
                            <span>1.0.0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Laravel:</span>
                            <span>{{ app()->version() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Environment:</span>
                            <span>{{ app()->environment() }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-white mb-2">Server</h4>
                    <div class="space-y-2 text-sm text-gray-300">
                        <div class="flex justify-between">
                            <span>PHP Version:</span>
                            <span>{{ PHP_VERSION }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Server Software:</span>
                            <span>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-glass p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Quick Actions</h3>
            <div class="grid md:grid-cols-3 gap-4">
                <button class="btn btn-primary" onclick="backupDatabase()">
                    <i class="fas fa-database mr-2"></i>
                    Backup Database
                </button>
                <button class="btn btn-success" onclick="clearCache()">
                    <i class="fas fa-broom mr-2"></i>
                    Clear Cache
                </button>
                <button class="btn btn-warning" onclick="runDiagnostics()">
                    <i class="fas fa-stethoscope mr-2"></i>
                    Run Diagnostics
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Theme settings
document.getElementById('settingsThemeToggle').addEventListener('click', () => {
    document.getElementById('settingsThemeDropdown').classList.toggle('show');
});

document.querySelectorAll('#settingsThemeDropdown .theme-option').forEach(option => {
    option.addEventListener('click', () => {
        const theme = option.dataset.theme;
        applyTheme(theme);
        document.getElementById('settingsThemeDropdown').classList.remove('show');
        
        fetch('/admin/settings/theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ theme: theme })
        });
    });
});

function backupDatabase() {
    alert('Backup database functionality');
}

function clearCache() {
    alert('Clear cache functionality');
}

function runDiagnostics() {
    alert('Run diagnostics functionality');
}
</script>