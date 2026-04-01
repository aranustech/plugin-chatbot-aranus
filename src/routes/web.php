<?php

use Illuminate\Support\Facades\Route;
use Aranus\Chatbot\Http\Controllers\ChatRecordController;

Route::prefix('aranus-chatbot')->group(function () {
    Route::post('/store-chat', [ChatRecordController::class, 'store'])->name('chatbot.store');
    Route::get('/chat-records', [ChatRecordController::class, 'index'])->name('chatbot.index');
    Route::get('/popular-questions', [ChatRecordController::class, 'popularQuestions'])->name('chatbot.popular');
});