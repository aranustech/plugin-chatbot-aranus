<?php

return [
    'ws_url' => env('CHATBOT_WS_URL', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/chat'),
    'admin_ws_url' => env('CHATBOT_ADMIN_WS_URL', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin'),
    'upload_url' => env('CHATBOT_UPLOAD_URL', 'https://aranus-aranus-chatbot-plugin.hf.space/upload'),
    
    // Notifikasi
    'admin_email' => env('ADMIN_NOTIFICATION_EMAIL', 'dummy_anda@gmail.com'),

    // ==========================================
    // KONFIGURASI DASHBOARD ADMIN (Dinamic UI)
    // ==========================================
    // Layout blade utama aplikasi klien (misal: 'layouts.app' atau 'layouts.admin')
    'layout' => env('CHATBOT_LAYOUT', 'layouts.app'), 
    
    // Prefix URL untuk mengakses menu chatbot (misal: 'dashboard' atau 'admin')
    'prefix' => env('CHATBOT_PREFIX', 'dashboard'), 
    
    // Middleware untuk mengamankan halaman dashboard chatbot
    'middleware' => ['web', 'auth'], 
];