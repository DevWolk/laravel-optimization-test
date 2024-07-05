<?php

declare(strict_types=1);

use App\Services\RootService;
use App\Services\RootService2;
use Illuminate\Contracts\Http\Kernel;

require_once __DIR__ . '/laravel/vendor/autoload.php';

$count = 200;
$data = [];

for ($i = 0; $i < $count; $i++) {
    $app = require __DIR__ . '/laravel/bootstrap/app.php';
    $app->make(Kernel::class)->bootstrap();

    $start = microtime(true);
    $startMemory = memory_get_usage(true);
    $service = $app->make(RootService::class);
    $service = $app->make(RootService::class);
    $service = $app->make(RootService2::class);
    $service = $app->make(RootService2::class);
    $end = microtime(true);
    $endMemory = memory_get_usage(true);

    $data[] = [
        'time' => ($end - $start) * 1000,
        'memory' => $endMemory - $startMemory,
    ];

}

$averageTime = array_sum(array_column($data, 'time')) / $count;
$averageMemory = array_sum(array_column($data, 'memory')) / $count;

dump($averageTime . ' ms');
dump(($averageMemory / 1024) . ' KB');
