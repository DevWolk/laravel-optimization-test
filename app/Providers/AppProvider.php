<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Shared;
use App\Services\Shared2;
use App\Services\Shared3;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class AppProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->resolving(static function (mixed $class, Application $app): void {
            if (false === is_string($class)) {
                $class = get_class($class);
            }

            if (false === $class) {
                return;
            }

            if ($app->isShared($class)) {
                return;
            }

            ResolvedServices::count($class);
        });

        $this->app->when(Shared::class)
            ->needs('$val')
            ->give('val1');
        $this->app->when(Shared2::class)
            ->needs('$val')
            ->give('val2');
        $this->app->when(Shared3::class)
            ->needs('$val')
            ->give('val3');
    }
}
