<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;

class LiveChatController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Live Chat 2-Arah
     */
    public function index()
    {
        // Memanggil file dari resources/views/dashboard/live_chat.blade.php di dalam package
        return view('chatbot::dashboard.live_chat');
    }
}