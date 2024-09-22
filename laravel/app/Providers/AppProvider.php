<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\GlobalService;
use App\Services\GlobalService1;
use App\Services\GlobalService2;
use App\Services\GlobalService3;
use App\Services\GlobalService4;
use App\Services\GlobalService5;
use App\Services\LargeService;
use App\Services\LargeService2;
use App\Services\LargeService3;
use App\Services\LargeService4;
use App\Services\LargeService5;
use App\Services\RootService;
use App\Services\RootService2;
use App\Services\Service1;
use App\Services\Service12;
use App\Services\Service13;
use App\Services\Service14;
use App\Services\Service15;
use App\Services\Service2;
use App\Services\Service3;
use App\Services\Service4;
use App\Services\Service5;
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
            $this->app->scoped(GlobalService::class, GlobalService::class);
            $this->app->scoped(GlobalService1::class, GlobalService1::class);
            $this->app->scoped(GlobalService2::class, GlobalService2::class);
            $this->app->scoped(GlobalService3::class, GlobalService3::class);
            $this->app->scoped(GlobalService4::class, GlobalService4::class);
            $this->app->scoped(GlobalService5::class, GlobalService5::class);
            $this->app->scoped(LargeService::class, LargeService::class);
            $this->app->scoped(LargeService2::class, LargeService2::class);
            $this->app->scoped(LargeService3::class, LargeService3::class);
            $this->app->scoped(LargeService4::class, LargeService4::class);
            $this->app->scoped(LargeService5::class, LargeService5::class);
            $this->app->scoped(RootService::class, RootService::class);
            $this->app->scoped(RootService2::class, RootService2::class);
            $this->app->scoped(Service1::class, Service1::class);
            $this->app->scoped(Service2::class, Service2::class);
            $this->app->scoped(Service3::class, Service3::class);
            $this->app->scoped(Service4::class, Service4::class);
            $this->app->scoped(Service5::class, Service5::class);
            $this->app->scoped(Service12::class, Service12::class);
            $this->app->scoped(Service13::class, Service13::class);
            $this->app->scoped(Service14::class, Service14::class);
            $this->app->scoped(Service15::class, Service15::class);
        }
    }
}
