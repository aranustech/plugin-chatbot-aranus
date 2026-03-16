<?php

namespace Aranus\Chatbot\Console;

use Illuminate\Console\Command;

class InstallChatbot extends Command
{
    protected $signature = 'chatbot:install';

    protected $description = 'Install Aranus Chatbot package';

    public function handle()
    {
        $this->info('Installing Aranus Chatbot...');

        $this->call('vendor:publish', [
            '--tag' => 'chatbot-assets'
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'chatbot-config'
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'chatbot-views'
        ]);

        $this->call('migrate');

        $this->info('Chatbot installed successfully!');
    }
}