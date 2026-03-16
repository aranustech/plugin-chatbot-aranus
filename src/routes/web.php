<?php

use Illuminate\Support\Facades\Route;
use Aranus\Chatbot\Http\Controllers\ChatRecordController;

Route::post('/store-chat', [ChatRecordController::class, 'store'])->name('chat.store');

Route::get('/chat-records', [ChatRecordController::class, 'index'])->name('chat.index');

Route::get('/popular-questions', [ChatRecordController::class, 'popularQuestions']);

Route::get('/chatbot-icon', function () {
    return response()->file(base_path('packages/Aranus/Chatbot/icon-aranus.png'));
});