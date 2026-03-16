<p align="center">

<h1 align="center">plugin-chatbot-aranus</h1>

<p align="center">
Laravel Chatbot Integration Package<br>
Developed for <b>CV. Aranus Technology</b>
</p>

<p align="center">

<img src="https://img.shields.io/packagist/v/aranus/chatbot?style=for-the-badge" />
<img src="https://img.shields.io/packagist/php-v/aranus/chatbot?style=for-the-badge" />
<img src="https://img.shields.io/packagist/l/aranus/chatbot?style=for-the-badge" />
<img src="https://img.shields.io/github/stars/Chicktickhack/chatbot?style=for-the-badge" />

</p>

</p>

---

# plugin-chatbot-aranus

**plugin-chatbot-aranus** adalah package chatbot untuk framework Laravel yang memungkinkan integrasi chatbot AI langsung ke dalam aplikasi web.

Plugin ini dirancang untuk memudahkan integrasi chatbot tanpa perlu konfigurasi rumit. Setelah package di-install melalui Composer, chatbot dapat langsung digunakan di dalam aplikasi Laravel.

Plugin ini saat ini dikembangkan secara khusus untuk kebutuhan internal **CV. Aranus Technology**, namun tetap dirancang agar fleksibel (dapat dikembangkan lagi dengan developer lain) dan dapat digunakan pada proyek Laravel lainnya.

---


# 📦 Installation

Install package menggunakan Composer:

```
composer require aranus/chatbot
```

Laravel akan secara otomatis mendeteksi package melalui fitur **Package Auto Discovery**.

---

# 🚀 Usage

Tempelkan ini di layout yang ingin ditampilkan chatbot

    @yield('content')
    @chatbot

---

# 💾 Chat Record Storage
*Plugin ini menyediakan penyimpanan riwayat percakapan chatbot ke dalam database 

jalankan :
```
php artisan migrate
```
catatan : Jika terjadi error autoload :
```
composer dump-autoload
php artisan optimize:clear
```
pastikan di database sudah memiliki tabel:

```
chat_records
```

Struktur tabel:

```
id
session_code
client_message
ai_message
waktu
created_at
updated_at
```

### Field Description

| Field          | Description                          |
| -------------- | ------------------------------------ |
| session_code   | ID unik untuk setiap sesi percakapan |
| client_message | pesan yang dikirim oleh pengguna     |
| ai_message     | respon yang diberikan oleh AI        |
| waktu          | waktu percakapan terjadi             |
| created_at     | timestamp default Laravel            |
| updated_at     | timestamp default Laravel            |

---


# ⚙️ Requirements

* PHP 8.1+
* Laravel 10 / 11 / 12
* Composer

---

# 📁 Package Information

| Item       | Value                 |
| ---------- | --------------------- |
| Package    | aranus/chatbot        |
| Framework  | Laravel               |
| License    | MIT                   |
| Maintainer | CV. Aranus Technology |

---

# 🏢 Maintainer

Developed and maintained by

**CV. Aranus Technology**

---


<p align="center">

intern project
</p>
