<?php

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

echo '<style>body{font-family:monospace;background:#0f0f0f;color:#00ff88;padding:30px}h2{color:#fff}table{border-collapse:collapse;width:100%}td,th{border:1px solid #333;padding:8px 12px;text-align:left}th{background:#1a1a1a;color:#fff}.warn{color:#ffcc00}.ok{color:#00ff88}.err{color:#ff6b6b}</style>';
echo '<h2>🔍 NamiKahwin Debug</h2>';

// Check route cache files
echo '<h3 style="color:#fff">Route Cache Files:</h3><table><tr><th>File</th><th>Status</th></tr>';
$cacheFiles = [
    'bootstrap/cache/routes-v7.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/config.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/services.php',
];
$base = dirname(__DIR__);
foreach ($cacheFiles as $f) {
    $full = $base . '/' . $f;
    $exists = file_exists($full);
    echo '<tr><td>' . $f . '</td><td class="' . ($exists ? 'warn' : 'ok') . '">' . ($exists ? '⚠️ ADA (cached)' : '✓ Tiada') . '</td></tr>';
}
echo '</table>';

// Check web.php last modified
$webPhp = $base . '/routes/web.php';
echo '<h3 style="color:#fff">routes/web.php:</h3>';
echo '<p class="ok">Last modified: ' . date('Y-m-d H:i:s', filemtime($webPhp)) . '</p>';
echo '<pre style="background:#1a1a1a;padding:16px;border-radius:8px;overflow:auto;color:#ccc">' . htmlspecialchars(file_get_contents($webPhp)) . '</pre>';

// Check view cache
$viewDir = $base . '/storage/framework/views';
$views = glob($viewDir . '/*.php');
echo '<h3 style="color:#fff">Cached Views: ' . count($views) . ' files</h3>';

echo '<p style="color:#ffcc00;margin-top:20px">⚠️ Padam fail ini selepas guna!</p>';
echo '<a href="/" style="color:#00ff88">← Balik</a>';
