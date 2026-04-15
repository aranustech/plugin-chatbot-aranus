<?php

use Illuminate\Support\Facades\Route;
use Aranus\Chatbot\Http\Controllers\ChatRecordController;
use Aranus\Chatbot\Http\Controllers\LiveChatController;
use Aranus\Chatbot\Http\Controllers\KnowledgeBaseController;

// ==========================================
// RUTE V1: API WIDGET PENGUNJUNG (PUBLIK)
// ==========================================
Route::prefix('aranus-chatbot')->group(function () {
    Route::post('/store-chat', [ChatRecordController::class, 'store'])->name('chatbot.store');
    Route::get('/chat-records', [ChatRecordController::class, 'index'])->name('chatbot.index');
    Route::get('/popular-questions', [ChatRecordController::class, 'popularQuestions'])->name('chatbot.popular');
});

// ==========================================
// RUTE V2: DASHBOARD ADMIN (PROTECTED)
// ==========================================
// Kita asumsikan website yang menginstal package ini menggunakan prefix '/dashboard' 
// dan menggunakan middleware bawaan Laravel ('web' dan 'auth') untuk keamanan.
Route::middleware(['web', 'auth'])->prefix('dashboard')->group(function () {
    
    // 1. Halaman Live Chat 2-Arah
    Route::get('/live-chat', [LiveChatController::class, 'index'])->name('chatbot.livechat');
    
    // 2. Halaman Knowledge Base (Upload & Sinkronisasi Dokumen)
    Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('chatbot.kb');
    Route::post('/knowledge-base/upload', [KnowledgeBaseController::class, 'upload'])->name('chatbot.kb.upload');
    
    // 3. Halaman Dataset (Melihat teks yang diekstrak AI)
    Route::get('/knowledge-base/dataset', [KnowledgeBaseController::class, 'dataset'])->name('chatbot.kb.dataset');
    
});