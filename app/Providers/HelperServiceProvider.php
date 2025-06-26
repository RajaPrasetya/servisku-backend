<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register helper files
        $this->loadHelpers();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Load helper files
     */
    private function loadHelpers(): void
    {
        $helperFiles = [
            app_path('Helpers/helpers.php'),
        ];

        foreach ($helperFiles as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}
