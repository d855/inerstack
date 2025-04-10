<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();

        $this->configureDates();

        $this->configureModels();

        $this->configureUrls();

        $this->configureVite();
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    private function configureModels(): void
    {
        Model::unguard();

        Model::automaticallyEagerLoadRelationships();

        Model::shouldBeStrict();
    }

    private function configureUrls(): void
    {
        if ($this->app->isProduction()) {
            URL::forceHttps();
        }
    }

    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
