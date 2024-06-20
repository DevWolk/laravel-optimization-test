<?php

namespace App\Http\Controllers;

use App\Providers\ResolvedServices;
use App\Services\GlobalService;
use App\Services\RootService;
use App\Services\RootService2;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use function dump;

final readonly class Controller
{
    public function __construct(private Container $container)
    {
    }

    public function __invoke(): JsonResponse
    {
        $start = microtime(true);
        $startMemory = memory_get_usage();
        $service = $this->container->make(RootService::class);
        $service = $this->container->make(RootService::class);
        $service = $this->container->make(RootService2::class);
        $service = $this->container->make(RootService2::class);
        $end = microtime(true);
        $endMemory = memory_get_usage();

        dump('Time: '. ($end - $start) * 1000 . 'ms');
        dump('Memory: '. ($endMemory - $startMemory) / 1024 . 'KB');
        dump('Resolved services: ' . ResolvedServices::getCount());
        dump(ResolvedServices::get());

        return new JsonResponse([]);
    }
}
