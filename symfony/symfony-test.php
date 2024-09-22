<?php

declare(strict_types=1);

use App\Kernel;
use App\Services\RootService;
use App\Services\RootService2;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

(new Dotenv())->bootEnv(__DIR__ . '/.env');

$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
$kernel->boot();
$container = $kernel->getContainer();

$count = 200;
$data = [];

for ($i = 0; $i < $count; $i++) {
    $start = hrtime(true);
    $startMemory = memory_get_usage(true);

    $service1 = $container->get(RootService::class);
    $service2 = $container->get(RootService::class);
    $service3 = $container->get(RootService2::class);
    $service4 = $container->get(RootService2::class);

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