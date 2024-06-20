<?php

declare(strict_types=1);

namespace App\Services;

final readonly class Shared
{
    public function __construct(
        private string $val,
    ) {}
}
