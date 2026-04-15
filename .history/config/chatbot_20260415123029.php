<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URL WebSocket Pengunjung (Widget)
    |--------------------------------------------------------------------------
    | URL ini digunakan untuk menghubungkan widget chatbot di website
    | dengan engine AI di server Hugging Face.
    */
    'ws_url' => env('CHATBOT_WS_URL', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/chat'),
    'admin_ws_url' => env('CHATBOT_ADMIN_WS_URL', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin'),
    'upload_url' => env('CHATBOT_UPLOAD_URL', 'https://aranus-aranus-chatbot-plugin.hf.space/upload'),
    'admin_email' => env('ADMIN_NOTIFICATION_EMAIL', 'dummy_anda@gmail.com'),
];