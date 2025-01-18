<?php

namespace App\Providers;

use App\Models\ProductStock;
use App\Services\Store\PaginationService;
use App\Services\TranslationService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TranslationService::class, function ($app) {
            return new TranslationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::bootstrap-4');
    }
}
