<?php

namespace Aranus\Chatbot\Console;

use Illuminate\Console\Command;

class InstallChatbot extends Command
{
    /**
     * Nama perintah di terminal
     */
    protected $signature = 'chatbot:install';

    /**
     * Deskripsi perintah
     */
    protected $description = 'Menginstal dan mem-publish aset Aranus Chatbot V2';

    public function handle()
    {
        $this->info('🚀 Memulai instalasi Aranus Chatbot...');

        // 1. Publish Config
        $this->comment('Mem-publish file konfigurasi...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'chatbot-config', 
            '--force' => true
        ]);

        // 2. Publish Assets (Gambar Ikon & CSS)
        $this->comment('Mem-publish aset gambar & CSS...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'chatbot-assets', 
            '--force' => true
        ]);

        $this->info('✅ Aranus Chatbot V2 berhasil diinstal!');
        $this->line('Silakan jalankan perintah <bg=green;fg=white> php artisan migrate </> untuk membuat tabel chatbot di database Anda.');
    }
}