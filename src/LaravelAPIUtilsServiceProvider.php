<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils;

use Illuminate\Support\ServiceProvider;

class LaravelAPIUtilsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/api-utils.php',
            'api-utils'
        );
    }

    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/api-utils.php' => config_path('api-utils.php'),
            ],
            groups: 'api-utils',
        );
    }
}
