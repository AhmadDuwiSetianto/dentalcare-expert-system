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
// 🚑 PERBAIKAN KHUSUS VERCEL (ULTIMATE VERSION)
// =================================================================
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    // A. Setup Folder Storage di /tmp
    $storagePath = '/tmp/storage';
    $app->useStoragePath($storagePath);

    // B. Setup Folder Bootstrap Cache di /tmp (INI YANG BIKIN ERROR 500 TADI)
    $bootstrapCachePath = $storagePath . '/bootstrap/cache';
    
    // Paksa Laravel baca/tulis cache config di /tmp
    $_ENV['APP_PACKAGES_CACHE'] = $bootstrapCachePath . '/packages.php';
    $_ENV['APP_SERVICES_CACHE'] = $bootstrapCachePath . '/services.php';
    $_ENV['APP_ROUTES_CACHE'] = $bootstrapCachePath . '/routes-v7.php';
    $_ENV['APP_EVENTS_CACHE'] = $bootstrapCachePath . '/events.php';
    $_ENV['APP_CONFIG_CACHE'] = $bootstrapCachePath . '/config.php';

    // C. Buat Struktur Folder Otomatis (Jika belum ada)
    $folders = [
        $storagePath . '/framework/views',
        $storagePath . '/framework/cache',
        $storagePath . '/framework/sessions',
        $storagePath . '/logs',
        $bootstrapCachePath, // Folder bootstrap juga kita buat di /tmp
    ];

    foreach ($folders as $folder) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }
}
// =================================================================

// 4. Jalankan Aplikasi
$app->handleRequest(Request::capture());