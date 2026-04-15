<?php

namespace Aranus\Chatbot\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class BasicTestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            \Aranus\Chatbot\ChatbotServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('view.paths', array_merge([
            __DIR__ . '/views',
        ], $app['config']->get('view.paths', [])));
    }
}
