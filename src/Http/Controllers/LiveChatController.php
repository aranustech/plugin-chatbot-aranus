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
        $wsUrl = config('chatbot.admin_ws_url', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin');

        return view('chatbot::dashboard.live_chat', compact('wsUrl'));
    }
}
