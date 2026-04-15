@extends(config('chatbot.layout', 'layouts.app'))

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
                    <li aria-current="page">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                            </svg>
                            <span class="inline-flex items-center text-sm font-medium text-body-subtle">Knowledge Base</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-figtree !font-semibold">Knowledge Base</h2>
        </div>
    </section>

    <div class="p-4">
        <div class="mx-auto max-w-screen-xl space-y-6">

            {{-- Upload Card --}}
            <div class="bg-white relative shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[#00A86B]/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#00A86B]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Upload Dokumen</h3>
                            <p class="text-sm text-gray-500">Upload file untuk melatih kecerdasan AI Minara (PDF, CSV, TXT, XLSX, DOCX)</p>
                        </div>
                    </div>

                    {{-- 1. UBAH KE ROUTE PACKAGE: chatbot.kb.upload --}}
                    <form action="{{ route('chatbot.kb.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        {{-- Title input --}}
                        <div class="mb-4">
                            <label for="docTitle" class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumen (opsional)</label>
                            <input type="text" name="title" id="docTitle" placeholder="Kosongkan untuk menggunakan nama file..."
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00A86B] focus:border-[#00A86B]">
                        </div>

                        {{-- Drag & drop area --}}
                        <label id="dropArea" class="flex flex-col items-center justify-center w-full px-6 py-10 mb-4 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50/50 hover:bg-[#00A86B]/5 hover:border-[#00A86B] transition-all duration-300 group">
                            <svg class="w-12 h-12 text-gray-400 mb-3 group-hover:text-[#00A86B] transition-all duration-300 group-hover:scale-110 group-hover:-translate-y-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>
                            <span class="inline-block px-4 py-2 mb-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200 shadow-sm group-hover:bg-[#00A86B] group-hover:text-white group-hover:border-[#00A86B] transition-all duration-300">Pilih File Dokumen</span>
                            <span id="fileName" class="text-sm text-gray-400">Belum ada file dipilih... atau seret ke sini</span>
                            <input type="file" name="file" id="fileInput" accept=".pdf,.csv,.txt,.xlsx,.xls,.docx" class="hidden" required>
                        </label>

                        {{-- Buttons row --}}
                        <div class="flex items-center gap-3 flex-wrap">
                            <button type="submit" id="uploadBtn" disabled
                                class="inline-flex items-center gap-2 bg-[#00A86B] hover:bg-[#008f5b] disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed text-white text-sm font-semibold px-6 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md disabled:shadow-none">
                                <svg class="w-4 h-4" id="btnIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                                <span id="btnText">Upload & Latih AI</span>
                            </button>
                        </div>
                    </form>

                    {{-- Synchronize Button (separate form) --}}
                    <div class="mt-3">
                        {{-- 2. UBAH KE ROUTE PACKAGE: chatbot.kb.sync --}}
                        <form action="{{ route('chatbot.kb.sync') }}" method="POST" class="inline" id="syncForm">
                            @csrf
                            <button type="submit" id="syncBtn"
                                class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-5 py-3 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                                </svg>
                                Synchronize All
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Documents Table --}}
            <div class="bg-white relative shadow-md rounded-lg overflow-hidden">
                {{-- Toolbar --}}
                <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-wrap gap-3">
                    <div class="flex items-center gap-2 flex-1 min-w-[200px] max-w-md">
                        {{-- 3. UBAH KE ROUTE PACKAGE: chatbot.kb --}}
                        <form method="GET" action="{{ route('chatbot.kb') }}" class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dokumen..."
                                    class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#00A86B] focus:border-[#00A86B]"
                                    onchange="this.form.submit()">
                                <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}">
                            </div>
                        </form>

                        {{-- 4. UBAH KE ROUTE PACKAGE: chatbot.kb --}}
                        <a href="{{ route('chatbot.kb', ['search' => request('search'), 'sort' => request('sort', 'latest') === 'latest' ? 'oldest' : 'latest']) }}"
                            class="inline-flex items-center gap-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 text-gray-600 text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-150 whitespace-nowrap">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                            </svg>
                            {{ request('sort', 'latest') === 'latest' ? 'Latest' : 'Oldest' }}
                        </a>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            {{ $documents->total() }} Dokumen
                        </span>
                    </div>
                </div>

                {{-- Session Success --}}
                @if (session()->has('Success'))
                    <div class="m-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('Success') }}
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-gray-500 font-semibold">No.</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Dokumen</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Tipe</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Ukuran</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Upload By</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Sync</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">Status</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $i = ($documents->currentPage() - 1) * $documents->perPage() + 1; @endphp
                            @forelse ($documents as $doc)
                                <tr class="hover:bg-gray-50 transition-colors duration-100">
                                    <td class="px-4 py-3 text-gray-500">{{ $i++ }}</td>
                                    <td class="px-4 py-3">
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
                                            <div class="min-w-0">
                                                <p class="text-gray-900 font-medium truncate max-w-[200px]" title="{{ $doc->title }}">{{ $doc->title }}</p>
                                                <p class="text-xs text-gray-400 truncate max-w-[200px]" title="{{ $doc->original_name }}">{{ $doc->original_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium uppercase
                                            @switch($doc->file_type)
                                                @case('pdf') bg-red-50 text-red-600 @break
                                                @case('csv') @case('xlsx') @case('xls') bg-green-50 text-green-600 @break
                                                @case('docx') bg-blue-50 text-blue-600 @break
                                                @default bg-gray-50 text-gray-500
                                            @endswitch">
                                            {{ $doc->file_type }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $doc->formatted_size }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $doc->uploaded_by }}</td>
                                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $doc->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if($doc->sync_status === 'synced')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Synced
                                            </span>
                                        @elseif($doc->sync_status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <button type="button" class="toggle-status-btn relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none
                                            {{ $doc->status === 'active' ? 'bg-[#00A86B]' : 'bg-gray-300' }}"
                                            data-id="{{ $doc->id }}" data-status="{{ $doc->status }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200
                                                {{ $doc->status === 'active' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center">
                                            {{-- 5. UBAH KE ROUTE PACKAGE: chatbot.kb.destroy --}}
                                            <a href="#"
                                                class="inline-flex items-center gap-1 text-sm font-medium text-white bg-[#F23557] hover:bg-[#D4294B] px-3 py-1.5 rounded-lg transition-colors duration-150 delete-doc"
                                                data-url="{{ route('chatbot.kb.destroy', $doc->id) }}">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12H9.75m3 0H9.75m0 0V18m0-3v3m-4.5-9V3.375c0-.621.504-1.125 1.125-1.125h5.694c.255 0 .5.09.694.253l3.869 3.404a1.125 1.125 0 0 1 .389.852V18.75c0 .621-.504 1.125-1.125 1.125H6.375a1.125 1.125 0 0 1-1.125-1.125V6Z" />
                                            </svg>
                                            <p class="text-gray-400 text-sm">Belum ada dokumen yang diupload.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($documents->hasPages())
                    <div class="flex items-center justify-between p-4 border-t border-gray-200 flex-wrap gap-3">
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
    </div>
@endsection

@push('custome-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const fileNameDisplay = document.getElementById('fileName');
            const uploadBtn = document.getElementById('uploadBtn');
            const dropArea = document.getElementById('dropArea');
            const uploadForm = document.getElementById('uploadForm');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');

            // Drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
                dropArea.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); }, false);
            });
            ['dragenter', 'dragover'].forEach(e => {
                dropArea.addEventListener(e, () => dropArea.classList.add('!border-[#00A86B]', '!bg-[#00A86B]/5'));
            });
            ['dragleave', 'drop'].forEach(e => {
                dropArea.addEventListener(e, () => dropArea.classList.remove('!border-[#00A86B]', '!bg-[#00A86B]/5'));
            });
            dropArea.addEventListener('drop', e => {
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            });

            // File selected
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileNameDisplay.textContent = this.files[0].name;
                    fileNameDisplay.classList.remove('text-gray-400');
                    fileNameDisplay.classList.add('text-gray-800', 'font-medium');
                    uploadBtn.disabled = false;
                } else {
                    fileNameDisplay.textContent = 'Belum ada file dipilih... atau seret ke sini';
                    fileNameDisplay.classList.add('text-gray-400');
                    fileNameDisplay.classList.remove('text-gray-800', 'font-medium');
                    uploadBtn.disabled = true;
                }
            });

            // Upload submit - show loading
            uploadForm.addEventListener('submit', function() {
                uploadBtn.disabled = true;
                btnText.textContent = 'Memproses & Mengirim...';
                btnIcon.innerHTML = '<svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
            });

            // Synchronize confirm
            const syncForm = document.getElementById('syncForm');
            if (syncForm) {
                syncForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Synchronize Semua Dokumen?',
                        text: 'Semua dokumen aktif akan di-upload ulang ke server AI. Proses ini mungkin memakan waktu.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Synchronize!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const btn = syncForm.querySelector('button');
                            btn.disabled = true;
                            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Synchronizing...';
                            syncForm.submit();
                        }
                    });
                });
            }

            // Toggle status
            document.querySelectorAll('.toggle-status-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const dot = this.querySelector('span');
                    
                    // 6. UBAH KE ROUTE PACKAGE SECARA DINAMIS DI JS: chatbot.kb.toggle
                    const toggleUrl = `{{ route('chatbot.kb.toggle', ':id') }}`.replace(':id', id);

                    fetch(toggleUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'active') {
                            btn.classList.remove('bg-gray-300');
                            btn.classList.add('bg-[#00A86B]');
                            dot.classList.remove('translate-x-1');
                            dot.classList.add('translate-x-6');
                        } else {
                            btn.classList.remove('bg-[#00A86B]');
                            btn.classList.add('bg-gray-300');
                            dot.classList.remove('translate-x-6');
                            dot.classList.add('translate-x-1');
                        }
                    });
                });
            });

            // Delete document
            document.querySelectorAll('.delete-doc').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.dataset.url;
                    Swal.fire({
                        title: 'Hapus dokumen ini?',
                        text: 'Dokumen akan dihapus dari server dan database.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#F23557',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush