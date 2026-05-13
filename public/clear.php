<?php

// Clear all Laravel caches
$basePath = dirname(__DIR__);

$cleared = [];
$errors = [];

// 1. Clear route cache
$routeCache = $basePath . '/bootstrap/cache/routes-v7.php';
if (file_exists($routeCache)) {
    unlink($routeCache);
    $cleared[] = 'Route cache';
} else {
    // Try other route cache filename
    $routeCache2 = $basePath . '/bootstrap/cache/routes.php';
    if (file_exists($routeCache2)) {
        unlink($routeCache2);
        $cleared[] = 'Route cache (v1)';
    }
}

// 2. Clear config cache
$configCache = $basePath . '/bootstrap/cache/config.php';
if (file_exists($configCache)) {
    unlink($configCache);
    $cleared[] = 'Config cache';
}

// 3. Clear bootstrap cache
$appCache = $basePath . '/bootstrap/cache/packages.php';
if (file_exists($appCache)) {
    unlink($appCache);
    $cleared[] = 'Packages cache';
}

$servicesCache = $basePath . '/bootstrap/cache/services.php';
if (file_exists($servicesCache)) {
    unlink($servicesCache);
    $cleared[] = 'Services cache';
}

// 4. Clear framework cache files
$frameworkCache = $basePath . '/storage/framework/cache/data';
if (is_dir($frameworkCache)) {
    $files = glob($frameworkCache . '/*');
    foreach ($files as $file) {
        if (is_file($file)) unlink($file);
    }
    $cleared[] = 'Framework cache';
}

// 5. Clear compiled views
$viewCache = $basePath . '/storage/framework/views';
if (is_dir($viewCache)) {
    $files = glob($viewCache . '/*.php');
    foreach ($files as $file) {
        if (is_file($file)) unlink($file);
    }
    $cleared[] = 'View cache (' . count($files) . ' files)';
}

// Output result
echo '<style>body{font-family:monospace;background:#0f0f0f;color:#00ff88;padding:30px}h2{color:#fff}ul{line-height:2}.err{color:#ff6b6b}.btn{display:inline-block;margin-top:20px;padding:10px 20px;background:#ff4444;color:white;text-decoration:none;border-radius:6px;font-size:14px}</style>';
echo '<h2>✅ Cache Cleared!</h2><ul>';

foreach ($cleared as $item) {
    echo '<li>✓ ' . $item . '</li>';
}

if (empty($cleared)) {
    echo '<li>Tiada cache yang perlu dibersihkan.</li>';
}

echo '</ul>';
echo '<p style="color:#aaa;margin-top:20px">⚠️ <strong style="color:#ffcc00">PENTING: Padam fail clear.php ini selepas guna!</strong></p>';
echo '<a class="btn" href="/clear.php" onclick="fetch(\'/clear.php\').then(()=>location.reload())">Run Again</a>';
echo ' &nbsp; <a style="color:#aaa;font-size:13px" href="/">← Balik Landing Page</a>';
