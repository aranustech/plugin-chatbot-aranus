<?php

namespace Aranus\Chatbot\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    protected $table = 'knowledge_documents';

    // Sesuaikan persis dengan kolom migration asli Anda
    protected $fillable = [
        'title',
        'original_name',
        'filename',
        'file_path',
        'file_size',
        'file_type',
        'content',
        'status',
        'sync_status',
        'uploaded_by'
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];
    
    // Opsional: Accessor untuk format ukuran file (karena dipanggil di View Anda)
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 4) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}