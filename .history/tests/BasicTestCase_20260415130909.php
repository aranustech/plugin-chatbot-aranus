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
}
