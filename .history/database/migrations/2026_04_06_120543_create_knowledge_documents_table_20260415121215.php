<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_name');
            $table->string('filename');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('file_type', 20);
            $table->longText('content')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('sync_status', ['synced', 'pending', 'failed'])->default('pending');
            $table->string('uploaded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_documents');
    }
};