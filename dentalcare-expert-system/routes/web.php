<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect('/admin/dashboard');
        }
        return redirect('/diagnosis');
    }
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/home', [HomeController::class, 'index'])->name('app.home');

// Auth Controller Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected Routes - DIAGNOSIS (Untuk semua user yang login)
Route::middleware(['auth'])->group(function () {
    // Diagnosis Main Routes
    Route::get('/diagnosis', [DiagnosisController::class, 'index'])->name('diagnosis.index');
    Route::get('/diagnosis/load/{tab}', [DiagnosisController::class, 'loadTab'])->name('diagnosis.load');
    
    // Diagnosis Process Routes
    Route::post('/diagnosis/question', [DiagnosisController::class, 'getQuestion'])->name('diagnosis.question');
    Route::post('/diagnosis/process', [DiagnosisController::class, 'processAnswer'])->name('diagnosis.process');
    
    // Diagnosis Data Routes
    Route::get('/diagnosis/disease/{id}', [DiagnosisController::class, 'getDiseaseDetail'])->name('diagnosis.disease.detail');
    Route::get('/diagnosis/{id}/detail', [DiagnosisController::class, 'getDiagnosisDetail'])->name('diagnosis.detail');
    
    // Diagnosis Export/Download Routes
    Route::get('/diagnosis/{id}/download-pdf', [DiagnosisController::class, 'downloadPDF'])->name('diagnosis.pdf.download');
});

// Admin Routes - HANYA untuk admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard & Main Routes
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/load/{tab}', [AdminController::class, 'loadTab'])->name('admin.load');

    // ==================== USER MANAGEMENT ROUTES ====================
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'loadUsersTab'])->name('admin.users.index');
        Route::get('/{id}', [AdminController::class, 'getUser'])->name('admin.users.get');
        Route::put('/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/export/csv', [AdminController::class, 'exportUsers'])->name('admin.users.export');
    });

    // ==================== DISEASE MANAGEMENT ROUTES ====================
    Route::prefix('diseases')->group(function () {
        Route::get('/', [AdminController::class, 'loadDiseasesTab'])->name('admin.diseases.index');
        Route::post('/', [AdminController::class, 'storeDisease'])->name('admin.diseases.store');
        Route::get('/{id}', [AdminController::class, 'getDisease'])->name('admin.diseases.get');
        Route::put('/{id}', [AdminController::class, 'updateDisease'])->name('admin.diseases.update');
        Route::delete('/{id}', [AdminController::class, 'deleteDisease'])->name('admin.diseases.delete');
        Route::get('/{id}/symptoms', [AdminController::class, 'getDiseaseSymptoms'])->name('admin.diseases.symptoms');
    });

    // ==================== SYMPTOM MANAGEMENT ROUTES ====================
    Route::prefix('symptoms')->group(function () {
        Route::get('/', [AdminController::class, 'loadSymptomsTab'])->name('admin.symptoms.index');
        Route::post('/', [AdminController::class, 'storeSymptom'])->name('admin.symptoms.store');
        Route::get('/list', [AdminController::class, 'getSymptomsList'])->name('admin.symptoms.list');
        Route::get('/{id}', [AdminController::class, 'getSymptom'])->name('admin.symptoms.get');
        Route::get('/{id}/edit', [AdminController::class, 'editSymptom'])->name('admin.symptoms.edit');
        Route::put('/{id}', [AdminController::class, 'updateSymptom'])->name('admin.symptoms.update');
        Route::delete('/{id}', [AdminController::class, 'deleteSymptom'])->name('admin.symptoms.delete');
        Route::post('/{id}/toggle-status', [AdminController::class, 'toggleSymptomStatus'])->name('admin.symptoms.toggle-status');
        Route::get('/{id}/diseases', [AdminController::class, 'getSymptomDiseases'])->name('admin.symptoms.diseases');
    });

    // ==================== DIAGNOSIS MANAGEMENT ROUTES ====================
    Route::prefix('diagnoses')->group(function () {
        Route::get('/', [AdminController::class, 'loadDiagnosesTab'])->name('admin.diagnoses.index');
        Route::get('/{id}', [AdminController::class, 'getDiagnosis'])->name('admin.diagnoses.get');
        Route::delete('/{id}', [AdminController::class, 'deleteDiagnosis'])->name('admin.diagnoses.delete');
        Route::get('/export/csv', [AdminController::class, 'exportDiagnoses'])->name('admin.diagnoses.export');
        Route::get('/{id}/pdf', [AdminController::class, 'downloadDiagnosisPDF'])->name('admin.diagnoses.pdf');
    });

    // ==================== SETTINGS ROUTES ====================
    Route::prefix('settings')->group(function () {
        Route::get('/', [AdminController::class, 'loadSettingsTab'])->name('admin.settings.index');
        Route::post('/theme', [AdminController::class, 'updateTheme'])->name('admin.settings.theme');
    });
});

// ==================== FALLBACK ROUTES ====================
Route::fallback(function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect('/admin/dashboard');
        }
        return redirect('/diagnosis');
    }
    return redirect('/login');
    
});