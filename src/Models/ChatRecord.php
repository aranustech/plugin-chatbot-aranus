<?php

namespace Aranus\Chatbot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRecord extends Model
{
    use HasFactory;

    protected $table = 'chat_records';

    protected $fillable = [
        'session_code',
        'type',
        'client_message',
        'ai_message',
        'admin_message',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];
}