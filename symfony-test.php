<?php

declare(strict_types=1);

use App\Kernel;
use App\Services\RootService;
use App\Services\RootService2;

require_once __DIR__ . '/symfony/vendor/autoload.php';

$count = 200;
$data = [];

for ($i = 0; $i < $count; $i++) {
    $kernel = new Kernel('dev', false);
    $kernel->boot();
    $container = $kernel->getContainer();

    $start = microtime(true);
    $startMemory = memory_get_usage(true);
    $service = $container->get(RootService::class);
    $service = $container->get(RootService::class);
    $service = $container->get(RootService2::class);
    $service = $container->get(RootService2::class);
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
