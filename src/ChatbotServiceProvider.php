<?php

namespace Aranus\Chatbot;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChatbotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 1. Blade Directive (V1)
        Blade::directive('chatbot', function () {
            return "<?php echo view('chatbot::widget')->render(); ?>";
        });

        // 2. Load Routes (V1 & V2)
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // 3. Load Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'chatbot');

        // 4. Load Migrations (Otomatis jalan saat php artisan migrate tanpa perlu di-publish)
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // ==========================================
        // FITUR PUBLISH (Kustomisasi untuk Klien)
        // ==========================================

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/chatbot'),
        ], 'chatbot-views');

        $this->publishes([
            __DIR__ . '/../config/chatbot.php' => config_path('chatbot.php'),
        ], 'chatbot-config');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('vendor/chatbot'),
        ], 'chatbot-assets');
        
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