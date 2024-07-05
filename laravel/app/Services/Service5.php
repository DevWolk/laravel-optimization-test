<?php

declare(strict_types=1);

namespace App\Services;

final readonly class Service5
{
    public function __construct(
        private Service12 $service2,
        private Service13 $service3,
        private Service14 $service4,
        private Service15 $service5,
    ) {
    }
}
