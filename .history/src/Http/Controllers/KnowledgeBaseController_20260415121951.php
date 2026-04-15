<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Aranus\Chatbot\Models\KnowledgeDocument; // Memanggil Model dari dalam package

class KnowledgeBaseController extends Controller
{
    /**
     * Menampilkan halaman utama Knowledge Base (Upload Form & Tabel Dokumen)
     */
    public function index()
    {
        $documents = KnowledgeDocument::latest()->get();
        return view('chatbot::dashboard.knowledge-base.index', compact('documents'));
    }

    /**
     * Menangani proses upload file dan mengirimkannya ke API Hugging Face
     */
    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,txt,docx,csv,xlsx|max:20480', // Max 20MB
            'title' => 'nullable|string|max:255'
        ]);

        try {
            // 1. Simpan file sementara di storage Laravel
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('knowledge_base', $fileName, 'public');

            $title = $request->title ?? $file->getClientOriginalName();

            // 2. Simpan metadata ke Database dengan status pending
            $document = KnowledgeDocument::create([
                'title' => $title,
                'file_name' => $fileName,
                'file_path' => $path,
                'file_type' => $file->extension(),
                'file_size' => $file->getSize(),
                'sync_status' => 'pending',
                'uploader' => auth()->user()->name ?? 'Administrator'
            ]);

            // Catatan: Logika cURL/Http::post ke Hugging Face API (/upload) 
            // ditaruh di sini untuk mengekstrak teks dan menyimpannya ke Pinecone.
            // Gunakan env('CHATBOT_UPLOAD_URL') sebagai endpoint.

            return back()->with('success', 'Dokumen berhasil diunggah dan sedang diproses AI.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunggah: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman Dataset (Viewer teks hasil ekstraksi AI)
     */
    public function dataset()
    {
        // Hanya mengambil dokumen yang berhasil diekstrak dan memiliki konten teks
        $datasets = KnowledgeDocument::whereNotNull('content')
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(5);
                                     
        return view('chatbot::dashboard.knowledge-base.dataset', compact('datasets'));
    }
}