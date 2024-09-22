<?php

declare(strict_types=1);

use App\Services\RootService;
use App\Services\RootService2;
use Illuminate\Contracts\Http\Kernel;

require_once __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$count = 200;
$data = [];

for ($i = 0; $i < $count; $i++) {
    $start = hrtime(true);
    $startMemory = memory_get_usage(true);

    $service1 = $app->make(RootService::class);
    $service2 = $app->make(RootService::class);
    $service3 = $app->make(RootService2::class);
    $service4 = $app->make(RootService2::class);

    $end = hrtime(true);
    $endMemory = memory_get_usage(true);

    $data[] = [
        'time' => ($end - $start) / 1e+6, // Convert nanoseconds to milliseconds
        'memory' => $endMemory - $startMemory,
    ];
}

$averageTime = array_sum(array_column($data, 'time')) / $count;
$averageMemory = array_sum(array_column($data, 'memory')) / $count;

echo sprintf("Average time: %.6f ms\n", $averageTime);
echo sprintf("Average memory: %.2f KB\n", $averageMemory / 1024);
