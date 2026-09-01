<?php

/**
 * Vercel Serverless Entry Point for Laravel
 */

// Setup direktori writable di /tmp untuk environment serverless Vercel
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Forward request ke public index bawaan Laravel
require __DIR__ . '/../public/index.php';
