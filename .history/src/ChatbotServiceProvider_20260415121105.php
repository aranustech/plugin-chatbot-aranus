<?php

namespace Aranus\Chatbot;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChatbotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('chatbot', function () {
            return "<?php echo view('chatbot::widget')->render(); ?>";
        });

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'chatbot');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/chatbot'),
        ], 'chatbot-views');

        $this->publishes([
            __DIR__ . '/../config/chatbot.php' => config_path('chatbot.php'),
        ], 'chatbot-config');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('vendor/chatbot'),
        ], 'chatbot-assets');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'chatbot-migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/chatbot.php',
            'chatbot'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Aranus\Chatbot\Console\InstallChatbot::class,
            ]);
        }
    }
}