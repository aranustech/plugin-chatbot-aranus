<?php

namespace Aranus\Chatbot\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Aranus\Chatbot\Models\KnowledgeDocument;

class KnowledgeBaseController extends Controller
{
    private function getUploadUrl(): string
    {
        return config('chatbot.upload_url', 'https://aranus-aranus-chatbot-plugin.hf.space/upload');
    }

    /**
     * Menampilkan halaman utama Knowledge Base (Upload Form & Tabel Dokumen)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort   = $request->get('sort', 'latest');

        $documents = KnowledgeDocument::query()
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('original_name', 'like', "%{$search}%"))
            ->orderBy('created_at', $sort === 'oldest' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('chatbot::dashboard.knowledge-base.index', compact('documents'));
    }

    /**
     * Upload file → kirim ke AI Server → simpan di DB
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:pdf,txt,docx,csv,xlsx,xls|max:20480',
            'title' => 'nullable|string|max:255',
        ]);

        $file         = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension    = $file->getClientOriginalExtension();
        $filename     = Str::uuid() . '_' . time() . '.' . $extension;
        $title        = $request->input('title') ?: pathinfo($originalName, PATHINFO_FILENAME);

        try {
            $path = $file->storeAs('knowledge_base', $filename, 'public');

            // Kirim ke AI Server (HF FastAPI)
            $response = Http::timeout(120)
                ->attach('file', file_get_contents($file->getRealPath()), $originalName)
                ->post($this->getUploadUrl());

            $syncStatus = 'failed';
            $content    = null;

            if ($response->successful()) {
                $result     = $response->json();
                $syncStatus = 'synced';
                $content    = $result['content'] ?? $result['text'] ?? $result['extracted_text'] ?? null;
            }

            KnowledgeDocument::create([
                'title'         => $title,
                'original_name' => $originalName,
                'filename'      => $filename,
                'file_path'     => $path,
                'file_size'     => $file->getSize(),
                'file_type'     => strtolower($extension),
                'content'       => $content,
                'status'        => 'active',
                'sync_status'   => $syncStatus,
                'uploaded_by'   => auth()->user()->name ?? 'Administrator',
            ]);

            $msg = $syncStatus === 'synced'
                ? 'Dokumen berhasil diupload dan disinkronkan ke AI!'
                : 'Dokumen tersimpan, namun gagal sinkronisasi ke server AI. Gunakan tombol Synchronize nanti.';

            return back()->with('Success', $msg);

        } catch (\Throwable $e) {
            if (isset($path)) {
                KnowledgeDocument::create([
                    'title'         => $title,
                    'original_name' => $originalName,
                    'filename'      => $filename,
                    'file_path'     => $path,
                    'file_size'     => $file->getSize(),
                    'file_type'     => strtolower($extension),
                    'content'       => null,
                    'status'        => 'active',
                    'sync_status'   => 'failed',
                    'uploaded_by'   => auth()->user()->name ?? 'Administrator',
                ]);
            }

            return back()->with('Success', 'Dokumen tersimpan, tapi server AI sedang tidak aktif. Gunakan Synchronize saat server sudah hidup.');
        }
    }

    /**
     * Hapus dokumen dari storage dan database
     */
    public function destroy($id)
    {
        $document = KnowledgeDocument::findOrFail($id);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('Success', 'Dokumen berhasil dihapus permanen.');
    }

    /**
     * Toggle status aktif/tidak aktif (via AJAX)
     */
    public function toggleStatus($id)
    {
        $document         = KnowledgeDocument::findOrFail($id);
        $document->status = $document->status === 'active' ? 'inactive' : 'active';
        $document->save();

        return response()->json([
            'success' => true,
            'status'  => $document->status,
        ]);
    }

    /**
     * Re-upload semua dokumen aktif ke AI Server (setelah server restart/sleep)
     */
    public function synchronize()
    {
        $documents    = KnowledgeDocument::where('status', 'active')->get();
        $successCount = 0;
        $failCount    = 0;

        foreach ($documents as $doc) {
            $filePath = Storage::disk('public')->path($doc->file_path);

            if (!file_exists($filePath)) {
                $doc->update(['sync_status' => 'failed']);
                $failCount++;
                continue;
            }

            try {
                $response = Http::timeout(120)
                    ->attach('file', file_get_contents($filePath), $doc->original_name)
                    ->post($this->getUploadUrl());

                if ($response->successful()) {
                    $result  = $response->json();
                    $content = $result['content'] ?? $result['text'] ?? $result['extracted_text'] ?? null;

                    $doc->update([
                        'sync_status' => 'synced',
                        'content'     => $content ?? $doc->content,
                    ]);
                    $successCount++;
                } else {
                    $doc->update(['sync_status' => 'failed']);
                    $failCount++;
                }
            } catch (\Throwable $e) {
                $doc->update(['sync_status' => 'failed']);
                $failCount++;
            }
        }

        $msg = "Sinkronisasi selesai: {$successCount} berhasil" . ($failCount > 0 ? ", {$failCount} gagal." : ".");

        return back()->with('Success', $msg);
    }

    /**
     * Menampilkan halaman Dataset (viewer teks yang diekstraksi AI)
     */
    public function dataset(Request $request)
    {
        $search = $request->get('search');

        $datasets = KnowledgeDocument::whereNotNull('content')
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('chatbot::dashboard.knowledge-base.dataset', compact('datasets'));
    }
}
