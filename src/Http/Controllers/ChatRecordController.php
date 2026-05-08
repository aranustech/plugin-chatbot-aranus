<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Aranus\Chatbot\Models\ChatRecord;
use Aranus\Chatbot\Mail\LiveChatRequestMail;

class ChatRecordController extends Controller
{
    /**
     * Menyimpan log percakapan AI dari Widget
     */
    public function store(Request $request)
    {
        $request->validate([
            'session_code'   => 'nullable|string',
            'client_message' => 'required|string',
            'ai_message'     => 'required|string',
        ]);

        ChatRecord::create([
            'session_code'   => $request->input('session_code'),
            'type'           => 'ai',
            'client_message' => $request->input('client_message'),
            'ai_message'     => $request->input('ai_message'),
            'waktu'          => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Menyimpan history percakapan admin per sesi (Live Chat)
     */
    public function storeAdminChat(Request $request)
    {
        $request->validate([
            'session_code'       => 'required|string',
            'messages'           => 'required|array',
            'messages.*.sender'  => 'required|string',
            'messages.*.text'    => 'required|string',
            'messages.*.time'    => 'nullable|string',
        ]);

        $messages = $request->input('messages');

        $firstClientMsg = collect($messages)
            ->first(fn($m) => $m['sender'] === 'client');

        ChatRecord::create([
            'session_code'   => $request->input('session_code'),
            'type'           => 'admin',
            'client_message' => $firstClientMsg['text'] ?? '(no message)',
            'ai_message'     => null,
            'admin_message'  => json_encode($messages, JSON_UNESCAPED_UNICODE),
            'waktu'          => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Kirim email notifikasi ke admin saat klien request handover ke Live Chat
     */
    public function notifyAdminHandover(Request $request)
    {
        $request->validate([
            'session_code' => 'nullable|string',
        ]);

        $sessionCode = $request->input('session_code', 'unknown');
        $adminEmail  = config('chatbot.admin_email');

        if (empty($adminEmail)) {
            return response()->json([
                'success' => false,
                'message' => 'Admin email not configured. Set ADMIN_NOTIFICATION_EMAIL in .env',
            ], 422);
        }

        try {
            Mail::to($adminEmail)->send(new LiveChatRequestMail($sessionCode));

            return response()->json([
                'success' => true,
                'message' => 'Email notifikasi terkirim.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Chatbot: Gagal mengirim email notifikasi live chat: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email.',
            ], 500);
        }
    }

    /**
     * Menampilkan halaman Chat Log dashboard admin
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'ai');
        $sort = $request->get('sort', 'latest');

        $chats = ChatRecord::where('type', $type)
            ->when(
                $request->filled('start_date') && $request->filled('end_date'),
                fn($q) => $q->whereBetween('waktu', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ])
            )
            ->orderBy('waktu', $sort === 'oldest' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('chatbot::dashboard.chatlog.index', [
            'chats'  => $chats,
            'type'   => $type,
            'active' => 'chatlog',
        ]);
    }

    /**
     * API untuk mengambil Pertanyaan Populer di Widget
     */
    public function popularQuestions()
    {
        try {
            $popular = ChatRecord::select('client_message', DB::raw('COUNT(*) as total'))
                ->where('type', 'ai')
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
