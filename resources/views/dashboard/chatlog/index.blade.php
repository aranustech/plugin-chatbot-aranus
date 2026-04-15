@extends(config('chatbot.layout', 'layouts.app'))

@push('custome-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endpush

@section('content')
    <section id="breadcrumbs" class="mb-2">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse !pl-0">
                    <li class="inline-flex items-center">
                        <a href="/dashboard" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">
                            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                            </svg>
                            <span class="inline-flex items-center text-sm font-medium text-body-subtle">Chat Log</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-figtree !font-semibold">Chat Log</h2>
        </div>
    </section>

    <div class="p-4">
        <div class="mx-auto max-w-screen-xl">
            <div class="bg-white relative shadow-md rounded-lg overflow-hidden">

                {{-- Tabs AI / Admin --}}
                <div class="flex border-b border-gray-200">
                    {{-- UBAH KE ROUTE PACKAGE: chatbot.index --}}
                    <a href="{{ route('chatbot.index', array_merge(request()->except('type', 'page'), ['type' => 'ai'])) }}"
                       class="flex items-center gap-2 px-5 py-3 text-sm font-medium border-b-2 transition-colors duration-150
                              {{ $type === 'ai' ? 'border-[#3B82F6] text-[#3B82F6]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                        </svg>
                        Chat AI
                    </a>
                    {{-- UBAH KE ROUTE PACKAGE: chatbot.index --}}
                    <a href="{{ route('chatbot.index', array_merge(request()->except('type', 'page'), ['type' => 'admin'])) }}"
                       class="flex items-center gap-2 px-5 py-3 text-sm font-medium border-b-2 transition-colors duration-150
                              {{ $type === 'admin' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        Chat Admin
                    </a>
                </div>

                {{-- Toolbar --}}
                <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-wrap gap-3">
                    <div class="flex items-center gap-2 flex-1 min-w-[280px] max-w-2xl">
                        {{-- UBAH KE ROUTE PACKAGE: chatbot.index --}}
                        <form method="GET" action="{{ route('chatbot.index') }}" class="flex items-center gap-2 flex-1" id="filterForm">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="text" id="dateRange"
                                value="{{ request('start_date') && request('end_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') . ' – ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : '' }}"
                                placeholder="Filter by date range..."
                                readonly
                                class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                            <input type="hidden" name="start_date" id="startDateInput" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" id="endDateInput" value="{{ request('end_date') }}">
                            <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}">
                        </div>
                        <button id="clearFilter" type="button"
                            class="inline-flex items-center gap-1 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg transition-colors duration-150 whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Clear
                        </button>
                        </form>
                        {{-- UBAH KE ROUTE PACKAGE: chatbot.index --}}
                        <a href="{{ route('chatbot.index', ['type' => $type, 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'sort' => request('sort', 'latest') === 'latest' ? 'oldest' : 'latest']) }}"
                            class="inline-flex items-center gap-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 text-gray-600 text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-150 whitespace-nowrap">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                            </svg>
                            {{ request('sort', 'latest') === 'latest' ? 'Latest' : 'Oldest' }}
                        </a>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-gray-500 font-semibold">No.</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold">User</th>
                                @if($type === 'ai')
                                    <th class="px-4 py-3 text-gray-500 font-semibold">AI</th>
                                @else
                                    <th class="px-4 py-3 text-gray-500 font-semibold">Admin</th>
                                @endif
                                <th class="px-4 py-3 text-gray-500 font-semibold">Time</th>
                                <th class="px-4 py-3 text-gray-500 font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $i = ($chats->currentPage() - 1) * $chats->perPage() + 1; @endphp
                            @forelse($chats as $chat)
                                <tr class="hover:bg-gray-50 transition-colors duration-100">
                                    <td class="px-4 py-3 text-gray-500">{{ $i++ }}</td>
                                    <td class="px-4 py-3 text-gray-900 font-medium max-w-[200px] truncate">
                                        {{ Str::limit($chat->client_message, 50) }}
                                    </td>
                                    @if($type === 'ai')
                                        <td class="px-4 py-3 text-gray-500 max-w-[200px] truncate">
                                            @if($chat->ai_message)
                                                {{ Str::limit($chat->ai_message, 50) }}
                                            @else
                                                <em class="text-gray-400">(no reply yet)</em>
                                            @endif
                                        </td>
                                    @else
                                        <td class="px-4 py-3 text-gray-500 max-w-[200px] truncate">
                                            @if($chat->admin_message)
                                                @php
                                                    $adminMsgs = json_decode($chat->admin_message, true);
                                                    $preview = is_array($adminMsgs) ? collect($adminMsgs)->where('sender', 'admin')->pluck('text')->first() : $chat->admin_message;
                                                @endphp
                                                {{ Str::limit($preview ?? '(no admin reply)', 50) }}
                                            @else
                                                <em class="text-gray-400">(no admin reply)</em>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                                        {{ $chat->waktu ? $chat->waktu->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center">
                                            <button
                                                class="btn-view inline-flex items-center gap-1 text-sm font-medium text-white bg-[#3B82F6] hover:bg-[#2563EB] px-3 py-1.5 rounded-lg transition-colors duration-150"
                                                data-type="{{ $type }}"
                                                data-user="{{ e($chat->client_message) }}"
                                                data-ai="{{ e($chat->ai_message ?? '(no reply yet)') }}"
                                                data-admin="{{ e($chat->admin_message ?? '') }}"
                                                data-time="{{ $chat->waktu ? $chat->waktu->format('d M Y, H:i') : '-' }}">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">
                                        {{ $type === 'ai' ? 'No AI chat logs found.' : 'No admin chat logs found.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

               {{-- Pagination --}}
                <div class="flex items-center justify-between p-4 border-t border-gray-200 flex-wrap gap-3">
                    <span class="text-sm text-gray-500">
                        Showing
                        <span class="font-semibold text-gray-900">{{ $chats->firstItem() ?? 0 }}-{{ $chats->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-gray-900">{{ $chats->total() }}</span>
                    </span>
                    <div>
                        {{ $chats->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="chatModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 bg-gray-50">
                <h5 class="text-sm font-semibold text-gray-800 font-figtree" id="modalTitle">Conversation Detail</h5>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 flex flex-col gap-4 max-h-[70vh] overflow-y-auto">
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="modalTime"></span>
                </div>

                {{-- AI mode content --}}
                <div id="modalAIContent">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">User</p>
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-sm text-gray-800 whitespace-pre-wrap break-words" id="modalUser"></div>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">AI Response</p>
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 whitespace-pre-wrap break-words" id="modalAI"></div>
                    </div>
                </div>

                {{-- Admin mode content --}}
                <div id="modalAdminContent" class="hidden">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Initial Client Message</p>
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-sm text-gray-800 whitespace-pre-wrap break-words" id="modalAdminUser"></div>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Conversation Log</p>
                        <div class="space-y-2" id="modalAdminMessages"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custome-js')
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Date range picker
    $('#dateRange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'DD MMM YYYY',
            cancelLabel: 'Cancel',
            applyLabel: 'Apply'
        },
        opens: 'right',
        alwaysShowCalendars: true,
        startDate: $('#startDateInput').val() || moment(),
        endDate: $('#endDateInput').val() || moment(),
    });

    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD MMM YYYY') + ' – ' + picker.endDate.format('DD MMM YYYY'));
        $('#startDateInput').val(picker.startDate.format('YYYY-MM-DD'));
        $('#endDateInput').val(picker.endDate.format('YYYY-MM-DD'));
        $('#filterForm').submit();
    });

    $('#dateRange').on('cancel.daterangepicker', function() {
        $(this).val('');
        $('#startDateInput').val('');
        $('#endDateInput').val('');
    });

    document.getElementById('clearFilter').addEventListener('click', function() {
        document.getElementById('dateRange').value = '';
        document.getElementById('startDateInput').value = '';
        document.getElementById('endDateInput').value = '';
        document.getElementById('filterForm').submit();
    });

    // Modal
    const modal = document.getElementById('chatModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalAIContent = document.getElementById('modalAIContent');
    const modalAdminContent = document.getElementById('modalAdminContent');

    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.type;
            document.getElementById('modalTime').textContent = this.dataset.time;

            if (type === 'admin') {
                // Admin chat mode
                modalTitle.textContent = 'Admin Conversation Detail';
                modalAIContent.classList.add('hidden');
                modalAdminContent.classList.remove('hidden');

                document.getElementById('modalAdminUser').textContent = this.dataset.user;

                const messagesContainer = document.getElementById('modalAdminMessages');
                messagesContainer.innerHTML = '';

                try {
                    const adminData = JSON.parse(this.dataset.admin);
                    if (Array.isArray(adminData)) {
                        adminData.forEach(msg => {
                            const bubble = document.createElement('div');
                            const isClient = msg.sender === 'client';
                            bubble.className = `p-3 rounded-lg text-sm whitespace-pre-wrap break-words ${isClient ? 'bg-blue-50 border border-blue-100' : 'bg-amber-50 border border-amber-200'}`;
                            bubble.innerHTML = `<span class="text-xs font-semibold ${isClient ? 'text-blue-600' : 'text-amber-600'}">${isClient ? 'Client' : 'Admin'}</span>` +
                                (msg.time ? `<span class="text-xs text-gray-400 ml-2">${msg.time}</span>` : '') +
                                `<div class="mt-1">${escapeHtml(msg.text)}</div>`;
                            messagesContainer.appendChild(bubble);
                        });
                    }
                } catch (e) {
                    messagesContainer.innerHTML = '<p class="text-sm text-gray-400">(Unable to parse conversation data)</p>';
                }
            } else {
                // AI chat mode
                modalTitle.textContent = 'Conversation Detail';
                modalAIContent.classList.remove('hidden');
                modalAdminContent.classList.add('hidden');

                document.getElementById('modalUser').textContent = this.dataset.user;
                document.getElementById('modalAI').textContent = this.dataset.ai;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.getElementById('closeModal').addEventListener('click', function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

});
</script>
@endpush