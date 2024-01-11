<?php

declare(strict_types=1);

namespace Thuraaung\APIUtils\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Thuraaung\APIUtils\LaravelAPIUtilsServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelAPIUtilsServiceProvider::class
        ];
    }

    /**
     * @param Application $app
     * @return array<string,class-string<Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [];
    }
}
