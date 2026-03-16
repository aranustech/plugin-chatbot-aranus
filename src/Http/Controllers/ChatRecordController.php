<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Aranus\Chatbot\src\Models\ChatRecord;

class ChatRecordController extends Controller
{
    public function store(Request $request)
    {

        dd($request->all());
        
        $request->validate([
            'session_code'   => 'nullable|string',
            'client_message' => 'required|string',
            'ai_message'     => 'required|string',
        ]);

        ChatRecord::create([
            'session_code'   => $request->input('session_code'),
            'client_message' => $request->input('client_message'),
            'ai_message'     => $request->input('ai_message'),
            'waktu'          => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $chatRecords = ChatRecord::orderBy('waktu', 'desc')->get();

        return view('dashboard.chatlog.index', [
            'chats'   => $chatRecords,
            'active'  => 'chatlog',
        ]);
    }

    public function popularQuestions()
    {
        try {
            $popular = ChatRecord::select('client_message', DB::raw('COUNT(*) as total'))
                ->whereNotNull('client_message')
                ->groupBy('client_message')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            return response()->json($popular);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil data: ' . $e->getMessage(),
            ], 500);
        }
    }
}