<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_records', function (Blueprint $table) {
            $table->id();
            $table->string('session_code')->nullable(); // ID unik tiap sesi percakapan
            $table->text('client_message')->nullable(); // pesan dari user
            $table->text('ai_message')->nullable(); // pesan dari AI
            $table->dateTime('waktu')->nullable(); // gabungan jam, tanggal, tahun
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_records');
    }
};
