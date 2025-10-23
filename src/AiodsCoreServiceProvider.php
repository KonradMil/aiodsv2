<?php

declare(strict_types=1);

namespace Aiods\Core;

use Illuminate\Support\ServiceProvider;

class AiodsCoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register any service container bindings here
        $this->registerCrudServices();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration file if needed
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/aiods-core.php' => config_path('aiods-core.php'),
            ], 'aiods-core-config');
        }
    }

    /**
     * Register CRUD services
     */
    private function registerCrudServices(): void
    {
        $this->app->singleton(\Aiods\Core\CRUD\QueryBuilder::class);
        $this->app->singleton(\Aiods\Core\CRUD\PaginationService::class);
        $this->app->singleton(\Aiods\Core\CRUD\CrudService::class);
    }
}

