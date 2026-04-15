<?php

namespace Aranus\Chatbot\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    /**
     * Tabel yang terhubung dengan model ini.
     */
    protected $table = 'knowledge_documents';

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'title',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'content',      // Menyimpan hasil ekstrak teks dari Hugging Face
        'sync_status',  // status: synced, pending, failed
        'is_active',    // status: true/false untuk toggle dokumen
        'uploader'
    ];

    /**
     * Cast properti ke tipe data native.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
    ];
}