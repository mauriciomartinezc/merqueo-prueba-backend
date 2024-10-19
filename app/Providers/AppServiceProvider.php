<?php

namespace App\Providers;

use App\Services\Team\TeamDestroyService;
use App\Services\Team\TeamIndexService;
use App\Services\Team\TeamShowService;
use App\Services\Team\TeamStoreService;
use App\Services\Team\TeamUpdateService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
