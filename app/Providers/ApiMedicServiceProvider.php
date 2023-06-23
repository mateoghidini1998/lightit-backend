<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ApiMedicService;

class ApiMedicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(ApiMedicService::class, function ($app) {
            $apiKey = config('services.apimedic.api_key'); 
            return new ApiMedicService($apiKey);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
