@extends('layouts.dashboard')

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
                            <span class="inline-flex items-center text-sm font-medium text-body-subtle">Live Chat Admin</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="font-figtree !font-semibold">Live Chat Monitoring</h2>
        </div>
    </section>

    <div class="p-4">
        <div class="mx-auto max-w-screen-xl">
            <div class="flex h-[75vh] min-h-[500px] bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                
                <div class="w-1/3 md:w-1/4 border-r border-gray-200 bg-gray-50 flex flex-col">
                    <div class="p-4 border-b border-gray-200 bg-[#00A86B] text-white">
                        <h3 class="font-semibold text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            Antrean Klien
                        </h3>
                    </div>
                    
                    <div id="client-list" class="flex-1 overflow-y-auto p-2 space-y-1 custom-scrollbar">
                        <div class="flex items-center justify-center h-full text-xs text-gray-400 text-center px-4">
                            Belum ada klien yang meminta bantuan Admin.
                        </div>
                    </div>
                </div>

                <div class="flex-1 flex flex-col relative bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50/50">
                    
                    <div class="p-4 border-b border-gray-200 bg-white flex justify-between items-center shadow-sm z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 shadow-inner" id="chat-avatar">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm" id="current-session-title">Pilih Obrolan</h3>
                                <p class="text-xs text-gray-400" id="current-session-id">Menunggu pilihan dari antrean...</p>
                            </div>
                        </div>
                        <button id="end-session-btn" class="hidden px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 hover:text-red-700 text-xs font-medium transition-colors shadow-sm">
                            Akhiri Sesi
                        </button>
                    </div>

                    <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar">
                        <div class="flex flex-col items-center justify-center h-full text-gray-400 gap-2 opacity-60">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-sm">Pilih klien di sidebar untuk mulai membalas pesan.</p>
                        </div>
                    </div>

                    <div class="p-3 bg-white border-t border-gray-200 shadow-[0_-2px_10px_rgba(0,0,0,0.02)] z-10">
                        <form id="chat-form" class="flex gap-2">
                            <input type="text" id="chat-input" disabled autocomplete="off"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A86B]/50 focus:border-[#00A86B] disabled:bg-gray-100 disabled:cursor-not-allowed text-sm transition-all" 
                                placeholder="Ketik balasan Anda di sini...">
                            <button type="submit" id="send-btn" disabled 
                                class="px-5 py-2 bg-[#00A86B] text-white rounded-xl font-medium hover:bg-[#008f5b] disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors shadow-sm flex items-center gap-2">
                                <span>Kirim</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@endsection

@push('custome-js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Mengambil URL WebSocket Admin dari Config Package
    const adminWsUrl = "{{ config('chatbot.admin_ws_url', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/admin') }}";
    let ws = null;
    let activeSessionId = null;

    const clientList = document.getElementById('client-list');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const endSessionBtn = document.getElementById('end-session-btn');
    const sessionTitle = document.getElementById('current-session-title');
    const sessionIdDisplay = document.getElementById('current-session-id');

    // Koneksi WebSocket
    function connect() {
        ws = new WebSocket(adminWsUrl);

        ws.onopen = () => {
            console.log('Tersambung ke Server WebSocket Admin Minara.');
        };

        ws.onmessage = (event) => {
            try {
                const data = JSON.parse(event.data);
                
                // Menangani List Klien (Misal server mengirim daftar array)
                if (data.type === 'client_list') {
                    renderClientList(data.clients);
                }
                
                // Menangani Pesan Masuk dari Klien
                if (data.type === 'message' && data.session_id === activeSessionId) {
                    appendMessage('client', data.text);
                }
                
                // Klien baru masuk antrean
                if (data.type === 'new_client') {
                    // Logic menambah list klien
                    console.log('Klien baru terhubung: ', data.session_id);
                }

            } catch (error) {
                // Jika server mengirim format teks biasa (Fallback)
                console.log('Raw WS Data:', event.data);
            }
        };

        ws.onclose = () => {
            console.log('Koneksi terputus. Mencoba menghubungkan kembali dalam 3 detik...');
            setTimeout(connect, 3000);
        };
    }

    // Fungsi Render Klien di Sidebar (Contoh Mockup Logic)
    function renderClientList(clients) {
        if (!clients || clients.length === 0) {
            clientList.innerHTML = '<div class="flex items-center justify-center h-full text-xs text-gray-400 text-center px-4">Belum ada klien yang meminta bantuan.</div>';
            return;
        }
        
        clientList.innerHTML = '';
        clients.forEach(client => {
            const el = document.createElement('div');
            el.className = `p-3 mb-1 rounded-lg cursor-pointer transition-colors border ${activeSessionId === client.id ? 'bg-[#00A86B]/10 border-[#00A86B]/30' : 'bg-white border-transparent hover:bg-gray-100'}`;
            el.innerHTML = `
                <div class="flex justify-between items-start">
                    <span class="font-semibold text-sm text-gray-800">Client #${client.id.substring(0, 4)}</span>
                    <span class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full font-medium">Menunggu</span>
                </div>
                <p class="text-xs text-gray-500 mt-1 truncate">${client.last_message || 'Meminta bantuan admin...'}</p>
            `;
            el.onclick = () => selectClient(client.id);
            clientList.appendChild(el);
        });
    }

    // Fungsi Memilih Klien
    function selectClient(sessionId) {
        activeSessionId = sessionId;
        sessionTitle.textContent = `Client #${sessionId.substring(0, 4)}`;
        sessionIdDisplay.textContent = `ID: ${sessionId}`;
        
        // Aktifkan Input
        chatInput.disabled = false;
        sendBtn.disabled = false;
        endSessionBtn.classList.remove('hidden');
        chatInput.focus();

        // Bersihkan chat area
        chatMessages.innerHTML = '<div class="text-xs text-center text-gray-400 my-4 bg-gray-100 py-1 rounded-full mx-auto w-3/4">Anda terhubung dengan klien. Sapa mereka!</div>';
        
        // Render ulang sidebar untuk styling 'active'
        // renderClientList(currentClientsData); 
    }

    // Form Submit (Admin mengirim pesan)
    chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text || !activeSessionId || !ws) return;

        // Tampilkan pesan di UI Admin
        appendMessage('admin', text);

        // Kirim via WebSocket ke server
        const payload = {
            type: 'admin_reply',
            session_id: activeSessionId,
            text: text
        };
        ws.send(JSON.stringify(payload));
        
        chatInput.value = '';
    });

    // Mengakhiri Sesi
    endSessionBtn.addEventListener('click', () => {
        if (!activeSessionId) return;

        // Konfirmasi SweetAlert
        Swal.fire({
            title: 'Akhiri sesi ini?',
            text: "Klien akan dikembalikan ke AI Minara.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F23557',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Akhiri'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim sinyal putus ke server
                ws.send(JSON.stringify({ type: 'end_session', session_id: activeSessionId }));
                
                // Reset UI
                activeSessionId = null;
                sessionTitle.textContent = 'Pilih Obrolan';
                sessionIdDisplay.textContent = 'Menunggu pilihan dari antrean...';
                chatInput.disabled = true;
                sendBtn.disabled = true;
                endSessionBtn.classList.add('hidden');
                chatMessages.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 gap-2 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <p class="text-sm">Sesi telah diakhiri. Pilih klien lain di sidebar.</p>
                    </div>`;
            }
        });
    });

    // Menambah Bubble Chat ke UI
    function appendMessage(sender, text) {
        const div = document.createElement('div');
        const isAdmin = sender === 'admin';
        
        div.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'} animate-fade-in-up`;
        
        div.innerHTML = `
            <div class="max-w-[75%] rounded-2xl px-4 py-2 shadow-sm text-sm ${
                isAdmin 
                ? 'bg-[#00A86B] text-white rounded-br-sm' 
                : 'bg-white border border-gray-200 text-gray-800 rounded-bl-sm'
            }">
                ${text}
            </div>
        `;
        
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Mulai koneksi
    connect();
});
</script>

<style>
    /* CSS Khusus untuk Live Chat Admin */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.3s ease forwards; }
</style>
@endpush