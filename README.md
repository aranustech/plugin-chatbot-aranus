# Aranus Chatbot V2 (Minara AI)

Aranus Chatbot adalah package Laravel profesional untuk mengintegrasikan widget chatbot AI **Minara**, sistem **Live Chat Handover** (Admin), dan **RAG Knowledge Base** ke dalam ekosistem website Anda secara *plug-and-play*.

---

## ✨ Fitur Utama (V2.0)

- 🤖 **Minara AI Widget**: Chatbot cerdas berbasis AI yang siap membantu pengunjung website 24/7.
- 👨‍💼 **Human-in-the-Loop (Live Chat)**: Fitur oper alih percakapan dari AI ke Admin secara *real-time* menggunakan WebSocket.
- 📚 **RAG Knowledge Base**: Latih AI Minara dengan mengunggah dokumen (PDF, TXT, Excel, Docx) langsung dari dashboard.
- 🔍 **Dataset Viewer**: Pantau teks yang berhasil diekstraksi dan dipelajari oleh AI dari dokumen yang diunggah.
- 📝 **Advanced Chat Logs**: Rekaman riwayat obrolan yang terpisah antara interaksi AI dan Admin dengan filter rentang tanggal.

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

Perintah ini akan menyalin file konfigurasi, aset gambar, dan file migrasi ke project utama:

```bash
php artisan chatbot:install
```

### 3. Jalankan Migrasi Database

Buat tabel `chat_records` dan `knowledge_documents` yang diperlukan:

```bash
php artisan migrate
```

---

## ⚙️ Konfigurasi

Setelah instalasi, silakan buka file `.env` Anda dan tambahkan variabel berikut untuk menghubungkan ke server AI Aranus:

```env
# Endpoint WebSocket & API
CHATBOT_WS_URL="wss://aranus-aranus-chatbot-plugin.hf.space/ws/chat"
CHATBOT_ADMIN_WS_URL="wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin"
CHATBOT_UPLOAD_URL="https://aranus-aranus-chatbot-plugin.hf.space/upload"

# Notifikasi
ADMIN_NOTIFICATION_EMAIL="admin@aranustech.co.id"
```

---

## 🖥️ Penggunaan

### 1. Menampilkan Widget di Website

Tambahkan directive blade berikut di file layout utama Anda (misalnya `app.blade.php`), tepat sebelum tag penutup `</body>`:

```blade
@chatbot
```

### 2. Integrasi Dashboard Admin

Package ini secara otomatis mendaftarkan rute dashboard. Anda dapat menambahkan tautan berikut ke sidebar admin Anda:

| Menu | Route Name | Deskripsi |
|------|------------|-----------|
| Live Chat | `route('chatbot.livechat')` | Membalas pesan klien secara langsung |
| Knowledge Base | `route('chatbot.kb')` | Upload dokumen untuk melatih AI |
| Chat Logs | `route('chatbot.index')` | Melihat riwayat percakapan lengkap |

---

## 🧪 Testing

Package ini sudah dilengkapi dengan pengujian otomatis menggunakan PHPUnit. Untuk menjalankan tes:

```bash
composer test
```

---

## 📄 Lisensi

Package ini dilisensikan di bawah MIT License. Dikembangkan oleh Aranus Technology.
