<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Cek Maintenance Mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Load Composer
require __DIR__.'/../vendor/autoload.php';

// 3. Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// =================================================================
// 🚑 PERBAIKAN KHUSUS VERCEL (MULAI)
// =================================================================
// Kode ini memindahkan penyimpanan cache/log ke folder sementara (/tmp)
// karena Vercel tidak mengizinkan penulisan di folder biasa.

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $path = '/tmp/storage';
    $app->useStoragePath($path);

    // Buat folder-folder penting di dalam /tmp secara otomatis
    if (!is_dir($path . '/framework/views')) {
        mkdir($path . '/framework/views', 0777, true);
    }
    if (!is_dir($path . '/framework/cache')) {
        mkdir($path . '/framework/cache', 0777, true);
    }
    if (!is_dir($path . '/framework/sessions')) {
        mkdir($path . '/framework/sessions', 0777, true);
    }
    if (!is_dir($path . '/logs')) {
        mkdir($path . '/logs', 0777, true);
    }
}
// =================================================================
// 🚑 PERBAIKAN KHUSUS VERCEL (SELESAI)
// =================================================================

// 4. Jalankan Aplikasi
$app->handleRequest(Request::capture());