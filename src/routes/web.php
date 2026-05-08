<?php

use Illuminate\Support\Facades\Route;
use Aranus\Chatbot\Http\Controllers\ChatRecordController;
use Aranus\Chatbot\Http\Controllers\LiveChatController;
use Aranus\Chatbot\Http\Controllers\KnowledgeBaseController;

// ==========================================
// RUTE PUBLIK: API Widget & Notifikasi
// ==========================================
Route::prefix('aranus-chatbot')->group(function () {
    // Simpan percakapan AI dari widget
    Route::post('/store-chat', [ChatRecordController::class, 'store'])->name('chatbot.store');

    // Simpan percakapan admin dari Live Chat
    Route::post('/store-admin-chat', [ChatRecordController::class, 'storeAdminChat'])->name('chatbot.store.admin');

    // Kirim notifikasi email saat pengunjung minta handover ke admin
    Route::post('/notify-admin-handover', [ChatRecordController::class, 'notifyAdminHandover'])->name('chatbot.notify.handover');

    // Pertanyaan populer untuk ditampilkan di widget
    Route::get('/popular-questions', [ChatRecordController::class, 'popularQuestions'])->name('chatbot.popular');
});

// ==========================================
// RUTE DASHBOARD ADMIN (Protected & Dynamic)
// ==========================================
Route::middleware(config('chatbot.middleware', ['web', 'auth']))
    ->prefix(config('chatbot.prefix', 'dashboard'))
    ->group(function () {

    // 1. Chat Log
    Route::get('/chatlog', [ChatRecordController::class, 'index'])->name('chatbot.index');

    // 2. Live Chat 2-Arah
    Route::get('/live-chat', [LiveChatController::class, 'index'])->name('chatbot.livechat');

    // 3. Knowledge Base
    Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('chatbot.kb');
    Route::post('/knowledge-base/upload', [KnowledgeBaseController::class, 'upload'])->name('chatbot.kb.upload');
    Route::post('/knowledge-base/sync', [KnowledgeBaseController::class, 'synchronize'])->name('chatbot.kb.sync');
    Route::post('/knowledge-base/toggle/{id}', [KnowledgeBaseController::class, 'toggleStatus'])->name('chatbot.kb.toggle');
    Route::delete('/knowledge-base/{id}', [KnowledgeBaseController::class, 'destroy'])->name('chatbot.kb.destroy');
    Route::get('/knowledge-base/dataset', [KnowledgeBaseController::class, 'dataset'])->name('chatbot.kb.dataset');
});
