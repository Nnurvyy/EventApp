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
        if (basename($this->app->basePath()) === 'laravel-core' && file_exists($this->app->basePath() . '/../index.php')) {
            $this->app->usePublicPath(realpath($this->app->basePath() . '/..'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
