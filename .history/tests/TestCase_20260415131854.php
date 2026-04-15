<?php

namespace Aranus\Chatbot\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            \Aranus\Chatbot\ChatbotServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');

        if (extension_loaded('pdo_sqlite')) {
            $app['config']->set('database.connections.testing', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        } elseif (extension_loaded('pdo_mysql')) {
            $app['config']->set('database.connections.testing', [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'test'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);
        }

        $app['config']->set('view.paths', array_merge([
            __DIR__ . '/views',
        ], $app['config']->get('view.paths', [])));
    }

    protected function canUseDatabase(): bool
    {
        try {
            $this->app['db']->connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        if (! $this->canUseDatabase()) {
            $this->markTestSkipped('No supported database driver or database connection available for testing.');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }
}
