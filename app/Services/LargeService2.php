<?php

declare(strict_types=1);

namespace App\Services;

final readonly class LargeService2
{
    public function __construct(
        private Service1 $service1,
        private Service2 $service2,
        private Service3 $service3,
        private Service4 $service4,
    ) {
    }
}
