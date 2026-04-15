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

    /*
    |--------------------------------------------------------------------------
    | URL WebSocket Live Chat Admin
    |--------------------------------------------------------------------------
    | URL ini digunakan khusus di halaman dashboard admin untuk 
    | mengambil alih percakapan (Human-in-the-loop).
    */
    'admin_ws_url' => env('CHATBOT_ADMIN_WS_URL', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin'),

    /*
    |--------------------------------------------------------------------------
    | URL Upload Knowledge Base
    |--------------------------------------------------------------------------
    | URL API untuk mengirimkan file PDF/TXT ke server AI agar bisa diproses
    | dan dimasukkan ke dalam vector database (Pinecone).
    */
    'upload_url' => env('CHATBOT_UPLOAD_URL', 'https://aranus-aranus-chatbot-plugin.hf.space/upload'),
];