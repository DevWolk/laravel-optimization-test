<?php

declare(strict_types=1);

namespace App\Providers;

use function uasort;

final class ResolvedServices
{
    /**
     * @var array<string,int>
     */
    private static $services = [];

    private static int $count = 0;

    public static function count(string $class): void
    {
        if (false === isset(self::$services[$class])) {
            self::$services[$class] = 1;
            return;
        }

        self::$services[$class]++;
        self::$count++;
    }

    /**
     * @return array<string,int>
     */
    public static function get(): array
    {
        uasort(self::$services, static fn (int $a, int $b): int => $b <=> $a);
        return self::$services;
    }

    public static function getCount(): int
    {
        return self::$count;
    }

    public static function reset(): void
    {
        self::$count = 0;
        self::$services = [];
    }
}
