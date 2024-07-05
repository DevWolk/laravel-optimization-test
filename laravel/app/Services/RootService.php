<?php

declare(strict_types=1);

namespace App\Services;

final readonly class RootService
{
    public function __construct(
        private GlobalService $service,
        private GlobalService1 $service1,
        private GlobalService2 $service2,
        private GlobalService3 $service3,
        private GlobalService4 $service4,
        private GlobalService5 $service5,
    ) {
    }
}
