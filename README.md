# Aranus Chatbot — Minara AI

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aranus-tech/chatbot.svg?style=flat-square)](https://packagist.org/packages/aranus-tech/chatbot)
[![Total Downloads](https://img.shields.io/packagist/dt/aranus-tech/chatbot.svg?style=flat-square)](https://packagist.org/packages/aranus-tech/chatbot)
[![License](https://img.shields.io/packagist/l/aranus-tech/chatbot.svg?style=flat-square)](https://packagist.org/packages/aranus-tech/chatbot)

Package Laravel untuk mengintegrasikan chatbot AI **Minara**, sistem **Live Chat Handover** ke admin, dan **RAG Knowledge Base** ke website Laravel mana saja secara *plug-and-play*.

---

## Fitur

- **Minara AI Widget** — chatbot cerdas berbasis AI siap membantu pengunjung 24/7
- **Live Chat (Human-in-the-Loop)** — oper alih percakapan dari AI ke admin secara real-time via WebSocket
- **RAG Knowledge Base** — upload dokumen (PDF, TXT, Excel, DOCX) untuk melatih AI langsung dari dashboard
- **Dataset Viewer** — lihat teks yang berhasil diekstrak dan dipelajari oleh AI
- **Chat Log** — riwayat percakapan AI dan admin yang terpisah dengan filter tanggal
- **Notifikasi Email** — admin mendapat email otomatis saat pengunjung meminta Live Chat
- **UI Isolation** — CSS pre-compiled, tidak memerlukan Tailwind CSS di aplikasi host

---

## Persyaratan

- PHP `^8.1`
- Laravel `^10.0 | ^11.0 | ^12.0`
- Database MySQL / PostgreSQL / SQLite

---

## Instalasi

### 1. Install via Composer

```bash
composer require aranus-tech/chatbot
```

### 2. Jalankan perintah install

Perintah ini menerbitkan file konfigurasi (`config/chatbot.php`) dan aset CSS/ikon ke folder `public/vendor/chatbot`:

```bash
php artisan chatbot:install
```

### 3. Jalankan migrasi

Package secara otomatis mendaftarkan 2 tabel yang dibutuhkan:

```bash
php artisan migrate
```

---

## Konfigurasi

### 1. Environment variables (`.env`)

Tambahkan variabel berikut ke file `.env` project Anda:

```env
# WebSocket AI dan Admin
CHATBOT_WS_URL="wss://aranus-aranus-chatbot-plugin.hf.space/ws/chat"
CHATBOT_ADMIN_WS_URL="wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin"

# Endpoint upload dokumen ke AI server
CHATBOT_UPLOAD_URL="https://aranus-aranus-chatbot-plugin.hf.space/upload"

# Email yang menerima notifikasi saat pengunjung minta Live Chat
ADMIN_NOTIFICATION_EMAIL="admin@example.com"
```

### 2. Konfigurasi dashboard (`config/chatbot.php`)

Setelah `chatbot:install`, edit `config/chatbot.php` agar sesuai dengan struktur aplikasi Anda:

```php
return [
    // Nama layout Blade utama aplikasi Anda
    // Halaman dashboard chatbot akan di-extend dari layout ini
    'layout' => 'layouts.app',

    // Prefix URL untuk semua halaman dashboard chatbot
    // Contoh: 'dashboard' -> /dashboard/chatlog, /dashboard/live-chat, dst.
    'prefix' => 'dashboard',

    // Middleware yang melindungi halaman dashboard chatbot
    'middleware' => ['web', 'auth'],
];
```

---

## Penggunaan

### Widget Chatbot (Frontend)

Tambahkan baris berikut ke layout utama website Anda (misalnya `resources/views/layouts/app.blade.php`):

```blade
<head>
    {{-- CSS widget chatbot --}}
    <link rel="stylesheet" href="{{ asset('vendor/chatbot/chatbot-ui.css') }}">
</head>

<body>
    {{-- Konten website Anda --}}

    {{-- Widget chatbot — letakkan sebelum </body> --}}
    @chatbot
</body>
```

Widget akan muncul sebagai tombol mengambang di pojok kanan bawah halaman.

---

### Dashboard Admin

Package mendaftarkan rute dashboard secara otomatis berdasarkan `prefix` dan `middleware` di `config/chatbot.php`.

Tambahkan tautan berikut ke sidebar navigasi admin Anda:

```blade
<a href="{{ route('chatbot.index') }}">Chat Log</a>
<a href="{{ route('chatbot.livechat') }}">Live Chat</a>
<a href="{{ route('chatbot.kb') }}">Knowledge Base</a>
<a href="{{ route('chatbot.kb.dataset') }}">Dataset</a>
```

**Daftar lengkap named routes:**

| Route Name | Method | URL (default prefix: `dashboard`) | Deskripsi |
|---|---|---|---|
| `chatbot.index` | GET | `/dashboard/chatlog` | Riwayat percakapan AI & Admin |
| `chatbot.livechat` | GET | `/dashboard/live-chat` | Dashboard Live Chat admin |
| `chatbot.kb` | GET | `/dashboard/knowledge-base` | Upload & kelola dokumen AI |
| `chatbot.kb.upload` | POST | `/dashboard/knowledge-base/upload` | Upload dokumen |
| `chatbot.kb.sync` | POST | `/dashboard/knowledge-base/sync` | Sinkronisasi ulang ke AI server |
| `chatbot.kb.toggle` | POST | `/dashboard/knowledge-base/toggle/{id}` | Aktifkan/nonaktifkan dokumen |
| `chatbot.kb.destroy` | DELETE | `/dashboard/knowledge-base/{id}` | Hapus dokumen |
| `chatbot.kb.dataset` | GET | `/dashboard/knowledge-base/dataset` | Lihat teks hasil ekstraksi |

**Endpoint API publik (digunakan oleh widget secara internal):**

| Route Name | Method | URL | Deskripsi |
|---|---|---|---|
| `chatbot.store` | POST | `/aranus-chatbot/store-chat` | Simpan percakapan AI |
| `chatbot.store.admin` | POST | `/aranus-chatbot/store-admin-chat` | Simpan percakapan admin |
| `chatbot.notify.handover` | POST | `/aranus-chatbot/notify-admin-handover` | Kirim email notifikasi handover |
| `chatbot.popular` | GET | `/aranus-chatbot/popular-questions` | Ambil pertanyaan populer |

---

### Kustomisasi Tampilan

Jika ingin mengubah tampilan halaman dashboard, publish view-nya terlebih dahulu:

```bash
php artisan vendor:publish --tag=chatbot-views
```

File view akan disalin ke `resources/views/vendor/chatbot/`. Setelah itu Anda bisa mengedit bebas tanpa mempengaruhi package aslinya.

---

## Struktur Tabel Database

### `chat_records`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary key |
| `session_code` | string | Kode sesi unik pengunjung |
| `type` | enum('ai','admin') | Jenis percakapan |
| `client_message` | text | Pesan dari pengunjung |
| `ai_message` | text | Balasan dari AI (nullable) |
| `admin_message` | longtext | JSON array percakapan admin (nullable) |
| `waktu` | datetime | Waktu percakapan |

### `knowledge_documents`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary key |
| `title` | string | Judul dokumen |
| `original_name` | string | Nama file asli |
| `filename` | string | Nama file tersimpan |
| `file_path` | string | Path di storage |
| `file_size` | bigint | Ukuran file (bytes) |
| `file_type` | string | Ekstensi file |
| `content` | longtext | Teks hasil ekstraksi AI (nullable) |
| `status` | enum('active','inactive') | Status aktif/nonaktif |
| `sync_status` | enum('pending','synced','failed') | Status sinkronisasi ke AI server |
| `uploaded_by` | string | Nama admin yang upload |

---

## Publish Aset Secara Manual

Jika perlu menerbitkan aset secara terpisah:

```bash
# Konfigurasi
php artisan vendor:publish --tag=chatbot-config

# Aset CSS & ikon (wajib untuk widget)
php artisan vendor:publish --tag=chatbot-assets

# View (opsional, untuk kustomisasi tampilan)
php artisan vendor:publish --tag=chatbot-views
```

---

## Deploy ke Packagist

1. Push kode ke repository GitHub (pastikan `composer.json` sudah benar)
2. Buka [packagist.org](https://packagist.org) dan login
3. Klik **Submit** dan masukkan URL repository GitHub
4. Aktifkan **GitHub Webhook** agar versi baru otomatis terdeteksi
5. Tag versi rilis pertama di Git:

```bash
git tag v1.0.0
git push origin v1.0.0
```

Setelah itu package dapat diinstall dengan:

```bash
composer require aranus-tech/chatbot
```

---

## Lisensi

MIT License — dikembangkan oleh [Aranus Technology](https://aranustech.co.id).
