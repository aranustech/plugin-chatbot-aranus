@extends('layouts.dashboard')

@section('content')
    <section id="breadcrumbs" class="mb-2">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse !pl-0">
                    <li class="inline-flex items-center">
                        <a href="/dashboard" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">
                            <svg class="w-4 h-4 me-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                            </svg>
                            {{-- 1. UBAH KE ROUTE PACKAGE: chatbot.kb --}}
                            <a href="{{ route('chatbot.kb') }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">Knowledge Base</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                            </svg>
                            <span class="inline-flex items-center text-sm font-medium text-body-subtle">Dataset</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-figtree !font-semibold">Dataset Knowledge Base</h2>
        </div>
    </section>

    <div class="p-4">
        <div class="mx-auto max-w-screen-xl space-y-6">

            {{-- Header info --}}
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#00A86B]/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#00A86B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Dataset AI Minara</h3>
                            <p class="text-sm text-gray-500">Konten teks dari dokumen yang sudah diproses oleh AI</p>
                        </div>
                    </div>

                    {{-- Search --}}
                    {{-- 2. UBAH KE ROUTE PACKAGE: chatbot.kb.dataset --}}
                    <form method="GET" action="{{ route('chatbot.kb.dataset') }}" class="w-full sm:w-auto sm:min-w-[300px]">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dalam dataset..."
                                class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00A86B] focus:border-[#00A86B]"
                                onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
            </div>

            {{-- Document content cards --}}
            @forelse ($documents as $doc)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    {{-- Card header --}}
                    <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50/50 cursor-pointer" onclick="toggleContent('content-{{ $doc->id }}', 'chevron-{{ $doc->id }}')">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0
                                @switch($doc->file_type)
                                    @case('pdf') bg-red-50 text-red-500 @break
                                    @case('csv') @case('xlsx') @case('xls') bg-green-50 text-green-600 @break
                                    @case('docx') bg-blue-50 text-blue-500 @break
                                    @default bg-gray-50 text-gray-400
                                @endswitch">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $doc->title }}</h4>
                                <div class="flex items-center gap-2 text-xs text-gray-400 mt-0.5">
                                    <span class="uppercase font-medium
                                        @switch($doc->file_type)
                                            @case('pdf') text-red-500 @break
                                            @case('csv') @case('xlsx') @case('xls') text-green-600 @break
                                            @case('docx') text-blue-500 @break
                                            @default text-gray-400
                                        @endswitch">{{ $doc->file_type }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $doc->formatted_size }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $doc->created_at->format('d M Y, H:i') }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $doc->uploaded_by }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($doc->sync_status === 'synced')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Synced
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ ucfirst($doc->sync_status) }}
                                </span>
                            @endif
                            <svg id="chevron-{{ $doc->id }}" class="w-5 h-5 text-gray-400 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    {{-- Content body (hidden by default for all except first) --}}
                    <div id="content-{{ $doc->id }}" class="{{ $loop->first ? '' : 'hidden' }}">
                        <div class="p-4 max-h-[400px] overflow-y-auto">
                            @if($doc->content)
                                <pre class="whitespace-pre-wrap text-sm text-gray-700 leading-relaxed font-sans">{{ $doc->content }}</pre>
                            @else
                                <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                    <svg class="w-8 h-8 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <p class="text-sm">Konten belum tersedia. Lakukan Synchronize untuk mengambil konten dari server AI.</p>
                                </div>
                            @endif
                        </div>
                        @if($doc->content)
                            <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-xs text-gray-400">
                                {{ number_format(str_word_count($doc->content)) }} kata &middot; {{ number_format(strlen($doc->content)) }} karakter
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-md rounded-lg p-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    <p class="text-gray-400 text-sm">Belum ada dataset. Upload dokumen terlebih dahulu.</p>
                    {{-- 3. UBAH KE ROUTE PACKAGE: chatbot.kb --}}
                    <a href="{{ route('chatbot.kb') }}" class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-[#00A86B] hover:underline">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                        </svg>
                        Upload Dokumen
                    </a>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($documents->hasPages())
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <span class="text-sm text-gray-500">
                        Menampilkan
                        <span class="font-semibold text-gray-900">{{ $documents->firstItem() }}-{{ $documents->lastItem() }}</span>
                        dari
                        <span class="font-semibold text-gray-900">{{ $documents->total() }}</span>
                    </span>
                    <div>
                        {{ $documents->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('custome-js')
    <script>
        function toggleContent(contentId, chevronId) {
            const content = document.getElementById(contentId);
            const chevron = document.getElementById(chevronId);
            content.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }
    </script>
@endpush