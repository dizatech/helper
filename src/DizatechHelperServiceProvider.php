<?php

namespace Dizatech\Helper;

use Illuminate\Support\ServiceProvider;

class DizatechHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/lang/en/dizatech_helper.php' => lang_path('en/dizatech_helper.php'),
            __DIR__.'/lang/fa/dizatech_helper.php' => lang_path('fa/dizatech_helper.php'),
        ]);
    }
}
