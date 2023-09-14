<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Services
        $models = [
            'Widget',
        ];
        foreach ($models as $model) {
            $this->app->bind("App\Services\\{$model}ServiceInterface", "App\Services\\{$model}Service");
        }

        // Repositories
        $this->app->bind("App\Repository\\ProviderInterface", "App\Services\\WidgetRepository");
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
