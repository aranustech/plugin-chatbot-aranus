<?php

namespace Aranus\Chatbot;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChatbotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 1. Blade Directive (V1 - Tetap dipertahankan)
        // Memungkinkan pengguna web cukup mengetik @chatbot di footer mereka
        Blade::directive('chatbot', function () {
            return "<?php echo view('chatbot::widget')->render(); ?>";
        });

        // 2. Load Routes (Mencakup Route V1 dan rute Dashboard V2 baru)
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // 3. Load Views (Prefix yang digunakan adalah 'chatbot::')
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'chatbot');

        // 4. Load Migrations (V1 & V2)
        // Otomatis membaca file migration chat_records (V1) & knowledge_documents (V2)
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

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'chatbot-migrations');
    }

    public function register()
    {
        // Gabungkan konfigurasi bawaan package dengan konfigurasi user
        $this->mergeConfigFrom(
            __DIR__ . '/../config/chatbot.php',
            'chatbot'
        );

        // Daftarkan Custom Artisan Command (Misal: php artisan chatbot:install)
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Aranus\Chatbot\Console\InstallChatbot::class,
            ]);
        }
    }
}