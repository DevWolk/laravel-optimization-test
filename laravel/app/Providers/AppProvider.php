<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Shared;
use App\Services\Shared2;
use App\Services\Shared3;
use Illuminate\Support\ServiceProvider;

final class AppProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(Shared::class)
            ->needs('$val')
            ->give('val1');
        $this->app->when(Shared2::class)
            ->needs('$val')
            ->give('val2');
        $this->app->when(Shared3::class)
            ->needs('$val')
            ->give('val3');

        if ($this->app['config']->get('app.auto-wiring')) {
            $this->app->scoped(Shared::class, Shared::class);
            $this->app->scoped(Shared2::class, Shared2::class);
            $this->app->scoped(Shared3::class, Shared3::class);
        }
    }
}
