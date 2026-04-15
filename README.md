# Aranus Chatbot V2 (Minara AI)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aranus-tech/chatbot.svg?style=flat-square)](https://packagist.org/packages/aranus-tech/chatbot)
[![Total Downloads](https://img.shields.io/packagist/dt/aranus-tech/chatbot.svg?style=flat-square)](https://packagist.org/packages/aranus-tech/chatbot)
[![License](https://img.shields.io/packagist/l/aranus-tech/chatbot.svg?style=flat-square)](https://packagist.org/packages/aranus-tech/chatbot)

Aranus Chatbot adalah package Laravel profesional untuk mengintegrasikan chatbot AI **Minara**, sistem **Live Chat Handover** (Admin), dan **RAG Knowledge Base** ke dalam ekosistem website Anda secara *plug-and-play*.

---

## ✨ Fitur Utama (V2.0)

- 🤖 **Minara AI Widget**: Chatbot cerdas berbasis AI yang siap membantu pengunjung website 24/7.
- 👨‍💼 **Human-in-the-Loop (Live Chat)**: Fitur oper alih percakapan dari AI ke Admin secara *real-time* menggunakan WebSocket.
- 📚 **RAG Knowledge Base**: Latih AI Minara dengan mengunggah dokumen (PDF, TXT, Excel, Docx) langsung dari dashboard.
- 🔍 **Dataset Viewer**: Pantau konten teks yang berhasil diekstraksi dan dipelajari oleh AI.
- 📝 **Advanced Chat Logs**: Riwayat percakapan lengkap yang dipisahkan antara interaksi AI dan Admin.
- 🎨 **UI Isolation**: Menggunakan *pre-compiled CSS* sehingga tampilan chatbot tetap konsisten tanpa merusak desain website asli klien (tidak memerlukan Tailwind di aplikasi utama).

---

## 📋 Persyaratan Sistem

- **PHP**: `^8.1`
- **Laravel**: `^10.0` | `^11.0` | `^12.0`
- **Database**: MySQL / PostgreSQL / SQLite

---

## 🚀 Instalasi

### 1. Instal melalui Composer

Tarik package ke dalam project Laravel Anda:

```bash
composer require aranus-tech/chatbot
```

### 2. Jalankan Perintah Instalasi

Perintah ini akan menyalin file konfigurasi (`config/chatbot.php`) dan aset visual (CSS & Ikon) ke folder publik project Anda:

```bash
php artisan chatbot:install
```

### 3. Jalankan Migrasi Database

Package ini secara otomatis memuat migrasi yang diperlukan untuk tabel log chat dan dokumen:

```bash
php artisan migrate
```

---

## ⚙️ Konfigurasi

### 1. Environment Variables (.env)
Tambahkan variabel berikut untuk menghubungkan widget dengan server AI Aranus:

```env
# Endpoint WebSocket & API
CHATBOT_WS_URL="wss://aranus-aranus-chatbot-plugin.hf.space/ws/chat"
CHATBOT_ADMIN_WS_URL="wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin"
CHATBOT_UPLOAD_URL="https://aranus-aranus-chatbot-plugin.hf.space/upload"

# Notifikasi
ADMIN_NOTIFICATION_EMAIL="admin@aranustech.co.id"
```

### 2. Konfigurasi Dashboard (config/chatbot.php)
Anda dapat menyesuaikan integrasi dashboard agar selaras dengan sistem admin yang sudah ada:

```php
return [
    'layout'     => 'layouts.app',      // Nama blade layout utama Anda
    'prefix'     => 'dashboard',       // Prefix URL (misal: dashboard/live-chat)
    'middleware' => ['web', 'auth'],   // Middleware untuk mengamankan akses admin
];
```

---

## 🖥️ Penggunaan

### 1. Menampilkan Widget di Website
Tambahkan pemanggilan CSS di tag `<head>` dan directive blade sebelum tag penutup `</body>` pada file layout utama Anda (misal: `app.blade.php`):

```blade
<head>
    <link rel="stylesheet" href="{{ asset('vendor/chatbot/chatbot-ui.css') }}">
</head>
<body>
    
    @chatbot
</body>
```

### 2. Integrasi Dashboard Admin
Package ini secara otomatis mendaftarkan rute dashboard. Anda cukup menambahkan tautan berikut ke sidebar navigasi admin Anda:

| Menu | Nama Route | Deskripsi |
|------|------------|-----------|
| **Live Chat** | `route('chatbot.livechat')` | Membalas pesan klien secara real-time |
| **Knowledge Base** | `route('chatbot.kb')` | Upload dokumen pelatihan AI |
| **Dataset** | `route('chatbot.kb.dataset')` | Lihat teks hasil ekstraksi AI |
| **Chat Logs** | `route('chatbot.index')` | Riwayat percakapan AI & Admin |

---

## 📄 Lisensi

Package ini dilisensikan di bawah MIT License. Dikembangkan oleh Aranus Technology.
