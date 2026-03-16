<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRecord extends Model
{
    use HasFactory;
    protected $table = 'chat_records';

    protected $fillable = [
        'session_code',
        'client_message',
        'ai_message',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];
}
