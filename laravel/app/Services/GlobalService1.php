<?php

declare(strict_types=1);

namespace App\Services;

final readonly class GlobalService1
{
    public function __construct(
        private LargeService $service2,
        private LargeService2 $service3,
        private LargeService4 $service4,
        private LargeService5 $service5,
    ) {
    }
}
