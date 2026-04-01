# Aranus Chatbot

Aranus Chatbot adalah package Laravel untuk menampilkan widget chatbot Minara pada website Anda.

## Requirements

- PHP ^8.1
- Laravel ^10.0 | ^11.0 | ^12.0

## Installation

Install package menggunakan Composer:

```bash
composer require aranus-tech/chatbot:dev-main
````

Laravel akan otomatis mendeteksi package melalui fitur Package Auto Discovery.

Setelah itu jalankan perintah install:

```bash
php artisan chatbot:install
```

## Configuration

Publish file konfigurasi jika diperlukan:

```bash
php artisan vendor:publish --tag=chatbot-config
```

Isi file `config/chatbot.php`:

```php
<?php

return [
    'ws_url' => env('CHATBOT_WS_URL', 'wss://aranus-api-chatbot.hf.space/ws/chat'),
    'icon_url' => env('CHATBOT_ICON_URL', 'https://www.aranustech.co.id/assets/icon-aranus2.png'),
];
```

Lalu tambahkan ke file `.env` jika ingin mengubah default:

```env
CHATBOT_WS_URL=wss://aranus-api-chatbot.hf.space/ws/chat
CHATBOT_ICON_URL=https://www.aranustech.co.id/assets/icon-aranus2.png
```

## Usage

Letakkan directive berikut di layout Blade utama, biasanya sebelum tag penutup `</body>`:

```blade
@chatbot
```

Contoh penggunaan:

```blade
<body>
    @yield('content')
    @chatbot
</body>
```

## Routes

Package ini mendaftarkan route berikut:

* `POST /aranus-chatbot/store-chat`
* `GET /aranus-chatbot/chat-records`
* `GET /aranus-chatbot/popular-questions`

## Notes

Pastikan layout utama Anda memiliki CSRF token:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

## Stable Release

Saat ini contoh instalasi menggunakan branch development:

```bash
composer require aranus-tech/chatbot:dev-main
```

Jika nanti package sudah memiliki tag release, Anda bisa mengubah instalasinya menjadi seperti ini:

```bash
composer require aranus-tech/chatbot:^1.0
```

## License

MIT
