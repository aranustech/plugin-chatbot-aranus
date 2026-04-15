<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Aranus\Chatbot\Models\ChatRecord;

class ChatRecordController extends Controller
{
    /**
     * Menyimpan log percakapan dari Widget (Bisa AI atau Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'session_code'   => 'nullable|string',
            'client_message' => 'required|string',
            'ai_message'     => 'nullable|string', // Ubah jadi nullable karena bisa jadi dibalas Admin
            'admin_message'  => 'nullable|string', // Tangkap pesan admin
        ]);

        ChatRecord::create([
            'session_code'   => $request->input('session_code'),
            'client_message' => $request->input('client_message'),
            'ai_message'     => $request->input('ai_message'),
            'admin_message'  => $request->input('admin_message'),
            'waktu'          => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Menampilkan halaman Chat Log dengan fitur Filter & Pagination
     */
    public function index(Request $request)
    {
        // Default ke tab 'ai' jika tidak ada request
        $type = $request->get('type', 'ai');
        
        $query = ChatRecord::query();

        // 1. Filter Tab (AI atau Admin)
        if ($type === 'admin') {
            $query->whereNotNull('admin_message');
        } else {
            // Tampilkan yang dibalas AI (termasuk jika admin belum sempat balas)
            $query->whereNull('admin_message'); 
        }

        // 2. Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // 3. Sorting (Terbaru / Terlama)
        if ($request->sort === 'oldest') {
            $query->oldest('waktu');
        } else {
            $query->latest('waktu');
        }

        // 4. Pagination (10 data per halaman)
        $chats = $query->paginate(10)->withQueryString();

        // Panggil view dari package (menggunakan prefix chatbot::)
        return view('chatbot::dashboard.chatlog.index', [
            'chats'  => $chats,
            'type'   => $type,
            'active' => 'chatlog',
        ]);
    }

    /**
     * API untuk mengambil Pertanyaan Populer di menu Widget
     */
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