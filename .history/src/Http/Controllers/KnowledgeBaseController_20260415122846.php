<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Aranus\Chatbot\Models\KnowledgeDocument;
use Illuminate\Support\Facades\Storage;

class KnowledgeBaseController extends Controller
{
    /**
     * 1. Menampilkan halaman utama Knowledge Base (Upload Form & Tabel Dokumen)
     */
    public function index(Request $request)
    {
        $query = KnowledgeDocument::query();

        // Fitur Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%");
        }

        // Fitur Sort (Bawaan dari UI)
        if ($request->sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        // Gunakan paginate() karena di blade kita menggunakan $documents->links()
        $documents = $query->paginate(10)->withQueryString();

        return view('chatbot::dashboard.knowledge-base.index', compact('documents'));
    }

    /**
     * 2. Menangani proses upload file dokumen
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,txt,docx,csv,xlsx,xls|max:20480', // Di form HTML namanya 'file'
            'title' => 'nullable|string|max:255'
        ]);

        try {
            // Simpan file sementara di storage Laravel
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('knowledge_base', $fileName, 'public');

            $title = $request->title ?? $file->getClientOriginalName();

            // Simpan metadata ke Database sesuai nama kolom migration asli Anda
            KnowledgeDocument::create([
                'title'         => $title,
                'original_name' => $file->getClientOriginalName(),
                'filename'      => $fileName,
                'file_path'     => $path,
                'file_size'     => $file->getSize(),
                'file_type'     => strtolower($file->getClientOriginalExtension()),
                'status'        => 'active',
                'sync_status'   => 'pending',
                'uploaded_by'   => auth()->user()->name ?? 'Administrator'
            ]);

            // CATATAN API: Logika HTTP::post ke server Hugging Face bisa disisipkan di sini nantinya
            // menggunakan endpoint: config('chatbot.upload_url')

            // View menggunakan session('Success') dengan S besar
            return back()->with('Success', 'Dokumen berhasil diunggah. Silakan klik Synchronize untuk melatih AI.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunggah: ' . $e->getMessage());
        }
    }

    /**
     * 3. Fitur Hapus Dokumen (Tombol Merah)
     */
    public function destroy($id)
    {
        $document = KnowledgeDocument::findOrFail($id);

        // Hapus file fisik dari storage agar hardisk tidak penuh
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('Success', 'Dokumen berhasil dihapus permanen.');
    }

    /**
     * 4. Fitur Toggle Status Aktif/Tidak Aktif (Via AJAX JavaScript)
     */
    public function toggleStatus($id)
    {
        $document = KnowledgeDocument::findOrFail($id);
        
        // Balikkan status
        $document->status = $document->status === 'active' ? 'inactive' : 'active';
        $document->save();

        return response()->json([
            'success' => true,
            'status' => $document->status
        ]);
    }

    /**
     * 5. Fitur Synchronize All (Tombol Oranye)
     */
    public function synchronize()
    {
        // CATATAN API: Di sini Anda mengeksekusi cURL / HTTP Request ke server Python
        // untuk mengirimkan semua dokumen yang statusnya 'active' dan 'pending'.
        
        // Contoh update status sementara di database:
        // KnowledgeDocument::where('status', 'active')->where('sync_status', 'pending')->update(['sync_status' => 'synced']);

        return back()->with('Success', 'Sinyal sinkronisasi telah dikirim ke Server Minara AI.');
    }

    /**
     * 6. Menampilkan halaman Dataset (Viewer teks)
     */
    public function dataset(Request $request)
    {
        // Hanya ambil dokumen yang punya konten teks
        $query = KnowledgeDocument::whereNotNull('content');

        // Fitur Search di dataset
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $datasets = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();
                                     
        return view('chatbot::dashboard.knowledge-base.dataset', compact('datasets'));
    }
}