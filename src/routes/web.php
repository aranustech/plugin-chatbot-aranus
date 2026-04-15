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
// RUTE V2: DASHBOARD ADMIN (PROTECTED & DYNAMIC)
// ==========================================
// Menggunakan konfigurasi middleware dan prefix dari config/chatbot.php
Route::middleware(config('chatbot.middleware', ['web', 'auth']))
    ->prefix(config('chatbot.prefix', 'dashboard'))
    ->group(function () {
    
    // 1. Halaman Live Chat 2-Arah
    Route::get('/live-chat', [LiveChatController::class, 'index'])->name('chatbot.livechat');
    
    // 2. Halaman Knowledge Base (Upload & Sinkronisasi Dokumen)
    Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('chatbot.kb');
    Route::post('/knowledge-base/upload', [KnowledgeBaseController::class, 'upload'])->name('chatbot.kb.upload');
    Route::post('/knowledge-base/sync', [KnowledgeBaseController::class, 'synchronize'])->name('chatbot.kb.sync');
    Route::post('/knowledge-base/toggle/{id}', [KnowledgeBaseController::class, 'toggleStatus'])->name('chatbot.kb.toggle');
    Route::delete('/knowledge-base/{id}', [KnowledgeBaseController::class, 'destroy'])->name('chatbot.kb.destroy');
    
    // 3. Halaman Dataset (Melihat teks yang diekstrak AI)
    Route::get('/knowledge-base/dataset', [KnowledgeBaseController::class, 'dataset'])->name('chatbot.kb.dataset');
    
});