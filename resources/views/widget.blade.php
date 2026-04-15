<link rel="stylesheet" href="{{ asset('vendor/chatbot/chatbot-ui.css') }}">

<script>
  // 1. Menggunakan config() agar URL WebSocket bisa diubah via .env klien
  window.CHATBOT_WS_URL = "{{ config('chatbot.ws_url', 'wss://aranus-aranus-chatbot-plugin.hf.space/ws/chat') }}";
</script>

<div id="chatbot-container" class="fixed bottom-20 right-4 sm:bottom-24 sm:right-6 z-[9999]">
  
  <div id="chatbot-welcome-card" style="opacity:0; transform:translateX(10px); pointer-events:none;" class="absolute bottom-20 right-0 bg-white/90 backdrop-blur-md text-gray-800 text-sm leading-relaxed p-4 w-64 rounded-xl shadow-xl z-0 origin-bottom-right border border-gray-200/50">
    <p class="m-0">Halo Client!<br>
      Saya <b>Minara</b> yang siap membantu jika Anda ingin mengetahui lebih lanjut tentang <b>Aranus Technology</b>.
    </p>
    <div class="welcome-card-tail"></div>
  </div>

  <div id="chatbot-toggle-wrapper" class="relative w-14 h-14 sm:w-16 sm:h-16 cursor-pointer group z-10 ml-auto flex-shrink-0">
    <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-[#00A86B] to-[#2BC48A] transition-transform duration-500 group-hover:rotate-180"></div>
    <div class="absolute inset-[3px] rounded-full bg-white z-10"></div>
    {{-- 2. Menggunakan path vendor untuk aset gambar package --}}
    <img id="chatbot-toggle" src="{{ asset('vendor/chatbot/icon-aranus.png') }}" alt="Chatbot Logo" onerror="this.src='/assets/icon-aranus.png'" class="absolute inset-[6px] w-[calc(100%-12px)] h-[calc(100%-12px)] rounded-full object-cover z-20 transition-all duration-300 group-hover:shadow-[0_0_15px_rgba(0,168,107,0.6)]" />
  </div>

  <div id="chatbot-box" class="hidden flex-col absolute bottom-[70px] sm:bottom-[80px] right-0 w-[calc(100vw-2rem)] sm:w-[400px] h-[70vh] max-h-[600px] bg-white/60 backdrop-blur-xl shadow-2xl rounded-2xl border border-[#2BC48A]/30 overflow-hidden transform transition-all duration-300 origin-bottom-right">
    
    <div id="chatbot-header" class="bg-[#00A86B]/90 backdrop-blur-sm text-white p-3 flex justify-between items-center shadow-md transition-colors duration-300">
      <div class="flex items-center gap-3">
        <img id="chatbot-resize" src="{{ asset('vendor/chatbot/icon-aranus.png') }}" onerror="this.src='/assets/icon-aranus.png'" alt="Logo" class="w-8 h-8 rounded-full bg-white object-contain p-0.5" />
        <div>
          <span class="font-semibold tracking-wide text-sm" id="chatbot-header-title">Minara Assistant</span>
          <div id="chatbot-mode-label" class="text-[10px] opacity-80 hidden"></div>
        </div>
      </div>
      <button id="chatbot-close" type="button" class="text-white hover:text-gray-300 text-2xl leading-none px-2 py-1 rounded focus:outline-none">&times;</button>
    </div>

    <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto flex flex-col gap-3 custom-scrollbar">
      
      <div class="flex items-start gap-2 mb-1">
        <img src="{{ asset('vendor/chatbot/icon-aranus.png') }}" onerror="this.src='/assets/icon-aranus.png'" alt="Logo Minara" class="w-8 h-8 rounded-full object-cover bg-white shrink-0 shadow-sm" />
        <div id="chatbot-halo-client" class="bg-gray-200/80 text-gray-800 self-start rounded-2xl rounded-tl-sm py-2 px-4 max-w-[80%] text-sm leading-relaxed shadow-sm transform transition-all duration-500 opacity-0 translate-y-2">
          Halo Client! Ada yang bisa saya bantu hari ini?
        </div>
      </div>
      <div id="chatbot-first-time" class="text-[10px] text-gray-400 mt-0.5 ml-10 text-left"></div>

      <div id="chatbot-main-menu" class="relative text-center text-gray-500 bg-white/80 border border-[#2BC48A]/50 rounded-2xl p-4 mt-4 shadow-md backdrop-blur-md transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
        <div class="text-sm font-semibold mb-3 text-gray-800">Pertanyaan Populer</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="popular-grid">
          <button type="button" class="menu-item flex items-center justify-start gap-2 bg-white border border-[#2BC48A]/40 text-gray-700 rounded-3xl p-3 text-left text-xs sm:text-sm hover:bg-[#00A86B] hover:text-white hover:border-[#00A86B] transition-all duration-200 shadow-sm" data-question="Apa saja layanan yang tersedia di Aranus Technology?">
            <span class="font-medium leading-tight">Apa saja layanan yang tersedia?</span>
          </button>
          <button type="button" class="menu-item flex items-center justify-start gap-2 bg-white border border-[#2BC48A]/40 text-gray-700 rounded-3xl p-3 text-left text-xs sm:text-sm hover:bg-[#00A86B] hover:text-white hover:border-[#00A86B] transition-all duration-200 shadow-sm" data-question="Bagaimana cara menghubungi tim Aranus Technology?">
            <span class="font-medium leading-tight">Bagaimana cara menghubungi tim?</span>
          </button>
          <button type="button" class="menu-item flex items-center justify-start gap-2 bg-white border border-[#2BC48A]/40 text-gray-700 rounded-3xl p-3 text-left text-xs sm:text-sm hover:bg-[#00A86B] hover:text-white hover:border-[#00A86B] transition-all duration-200 shadow-sm" data-question="Apakah Aranus Technology menyediakan konsultasi gratis?">
            <span class="font-medium leading-tight">Apakah tersedia konsultasi gratis?</span>
          </button>
          <button type="button" class="menu-item flex items-center justify-start gap-2 bg-white border border-[#2BC48A]/40 text-gray-700 rounded-3xl p-3 text-left text-xs sm:text-sm hover:bg-[#00A86B] hover:text-white hover:border-[#00A86B] transition-all duration-200 shadow-sm" data-question="Bagaimana proses kerja sama dengan Aranus Technology?">
            <span class="font-medium leading-tight">Bagaimana proses kerja sama?</span>
          </button>
        </div>
      </div>
    </div>

    {{-- Handover waiting banner --}}
    <div id="chatbot-waiting-banner" class="hidden px-3 py-2 bg-amber-50 border-t border-amber-200 text-center">
      <p class="text-xs text-amber-700 m-0">⏳ Menunggu admin tersedia...</p>
    </div>

    {{-- Shopee-style "Chat dengan Admin" bar --}}
    <div id="chatbot-handover-bar" class="chatbot-handover-bar hidden-bar" onclick="document.getElementById('chatbot-handover-bar').dispatchEvent(new CustomEvent('handover-click'))">
      <svg class="w-4 h-4 text-[#00A86B]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
      <span class="chatbot-handover-text">Chat dengan Admin</span>
    </div>

    <div class="p-3 bg-white/50 backdrop-blur-sm border-t border-gray-200/50 flex items-center gap-2">
      <input type="text" id="chatbot-input" placeholder="Tulis pesan..." class="flex-1 bg-white/60 border border-gray-300/60 rounded-full py-2 px-4 text-sm focus:outline-none focus:border-[#00A86B] focus:ring-1 focus:ring-[#2BC48A] transition-colors" />
      <button id="chatbot-send-btn" type="button" title="Kirim Pesan" class="w-9 h-9 flex items-center justify-center bg-[#00A86B] hover:bg-[#008f5b] text-white rounded-full transition-colors focus:outline-none shadow-sm shrink-0">
        <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
      </button>
    </div>
  </div>
</div>

@push('custome-js')
<script>
document.addEventListener('DOMContentLoaded', () => {

  function bindMenuButtons() {
    const buttons = document.querySelectorAll('#popular-grid .menu-item');
    buttons.forEach(btn => {
      btn.onclick = () => {
        const question = btn.dataset.question;
        if (!question) return;
        input.value = question;
        hideMainMenu();
        sendMessage();
        sessionStorage.setItem('chatbotMenuShown', 'true');
      };
    });
  }

  bindMenuButtons();

  if (window.__aranus_chatbot_init) return;
  window.__aranus_chatbot_init = true;

  const toggleBtn    = document.getElementById("chatbot-toggle");
  const toggleWrap   = document.getElementById("chatbot-toggle-wrapper");
  const chatBox      = document.getElementById("chatbot-box");
  const closeBtn     = document.getElementById("chatbot-close");
  const input        = document.getElementById("chatbot-input");
  const messages     = document.getElementById("chatbot-messages");
  const firstTimeEl  = document.getElementById("chatbot-first-time");
  const mainMenu     = document.getElementById("chatbot-main-menu");
  const welcomeCard  = document.getElementById("chatbot-welcome-card");
  const sendBtn      = document.getElementById("chatbot-send-btn");
  const menuGrid     = document.getElementById("popular-grid");
  const haloBubble   = document.getElementById("chatbot-halo-client");

  if (!toggleBtn || !chatBox || !closeBtn || !input || !messages || !sendBtn) return;

  let ws = null;
  let isStreaming = false;
  let currentBotBubble = null;
  let _pendingPayload = null;
  let haloShownOnce = false;

  let chatMode = 'ai'; // 'ai' | 'waiting' | 'live'
  const waitingBanner = document.getElementById('chatbot-waiting-banner');
  const handoverBar = document.getElementById('chatbot-handover-bar');
  const headerEl = document.getElementById('chatbot-header');
  const headerTitle = document.getElementById('chatbot-header-title');
  const modeLabel = document.getElementById('chatbot-mode-label');

  function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "";
  }

  function hideMainMenu() {
    if (mainMenu) mainMenu.style.display = "none";
  }

  function getTimeStr() {
    const now = new Date();
    return now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
  }

  function generateSessionId() {
    const id = 'aranus-' + Math.random().toString(36).substr(2, 9);
    sessionStorage.setItem("chat_session_code", id);
    return id;
  }

  setTimeout(() => {
    if(!chatBox.classList.contains('flex') && welcomeCard) {
      welcomeCard.style.opacity = '';
      welcomeCard.style.transform = '';
      welcomeCard.style.pointerEvents = '';
      welcomeCard.classList.add('welcome-animate');

      setTimeout(() => {
        if (welcomeCard) {
          welcomeCard.classList.add('welcome-hide');
          setTimeout(() => { welcomeCard.style.display = 'none'; }, 500);
        }
      }, 6000);
    }
  }, 1500);

  async function fetchPopularQuestions() {
    if (!menuGrid) return;
    const defaultQuestions = [
      "Apa saja layanan yang tersedia di Aranus Technology?",
      "Bagaimana cara menghubungi tim Aranus Technology?",
      "Apakah Aranus Technology menyediakan konsultasi gratis?",
      "Bagaimana proses kerja sama dengan Aranus Technology?"
    ];

    try {
      // 3. Memanggil Route Laravel via Helper untuk URL yang dinamis
      const res = await fetch('{{ route("chatbot.popular") }}');
      if (!res.ok) throw new Error('Gagal memuat API');
      const data = await res.json();
      let dbQuestions = [];
      if (Array.isArray(data) && data.length > 0) {
        dbQuestions = data.map(item => item.client_message?.trim()).filter(q => q && q.length > 0);
      }
      const finalQuestions = [...dbQuestions];
      for (let i = 0; finalQuestions.length < 4 && i < defaultQuestions.length; i++) {
        if (!finalQuestions.includes(defaultQuestions[i])) finalQuestions.push(defaultQuestions[i]);
      }
      const limitedQuestions = finalQuestions.slice(0, 4);
      menuGrid.innerHTML = '';
      limitedQuestions.forEach(text => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.dataset.question = text;
        btn.className = 'menu-item flex items-center justify-start gap-2 bg-white border border-[#2BC48A]/40 text-gray-700 rounded-3xl p-3 text-left text-xs sm:text-sm hover:bg-[#00A86B] hover:text-white hover:border-[#00A86B] transition-all duration-200 shadow-sm';
        btn.innerHTML = `<span class="font-medium leading-tight">${text}</span>`;
        menuGrid.appendChild(btn);
      });
      bindMenuButtons();
    } catch (err) {
      console.warn('API gagal, menggunakan fallback default HTML.');
    }
  }

  function disconnectWS() {
    if (ws) { try { ws.close(); } catch (e) {} }
    ws = null;
    isStreaming = false;
    _pendingPayload = null;
    currentBotBubble = null;
  }

  function connectWS() {
    if (ws && (ws.readyState === WebSocket.OPEN || ws.readyState === WebSocket.CONNECTING)) return;

    const wsUrl = window.CHATBOT_WS_URL;
    ws = new WebSocket(wsUrl);

    ws.onopen = () => {
      console.log("Terhubung ke AI Engine");
      if (_pendingPayload) {
        ws.send(JSON.stringify(_pendingPayload));
        _pendingPayload = null;
      }
    };

    ws.onmessage = (event) => {
      try {
        const data = JSON.parse(event.data);
        if (data.type) {
          handleSystemMessage(data);
          return;
        }
      } catch(e) { }

      if (typeof event.data === 'string') {
        if (event.data.startsWith('[ADMIN] ')) {
          removeWaitingBubble();
          if (chatMode !== 'live') setChatMode('live');
          appendAdminBubble(event.data.substring(8));
          return;
        }
        if (event.data.includes('[SYS_ADMIN_CONNECTED]')) {
          if (chatMode !== 'live') setChatMode('live');
          removeWaitingBubble();
          appendSystemBubble('✅ Admin telah terhubung. Anda sekarang berbicara dengan tim kami.');
          isStreaming = false;
          currentBotBubble = null;
          return;
        }
        if (event.data.includes('[SYS_ADMIN_DISCONNECTED]')) {
          if (chatMode !== 'ai') setChatMode('ai');
          removeWaitingBubble();
          appendSystemBubble('Sesi dengan Admin telah berakhir. Anda kini kembali dilayani oleh AI Minara.');
          isStreaming = false;
          currentBotBubble = null;
          return;
        }
      }

      if (event.data === "[END]") {
        isStreaming = false;
        const aiText = currentBotBubble ? currentBotBubble.textContent.trim() : "";
        const userBubbles = document.querySelectorAll(".chat-user-bubble");
        const lastUser = userBubbles[userBubbles.length - 1]?.textContent || "";
        const csrfToken = getCsrfToken();

        if (aiText && lastUser) {
          // 4. Memanggil Route Laravel via Helper untuk URL yang dinamis
          fetch("{{ route('chatbot.store') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              ...(csrfToken ? { "X-CSRF-TOKEN": csrfToken } : {})
            },
            credentials: "same-origin",
            body: JSON.stringify({
              session_code: sessionStorage.getItem("chat_session_code") || generateSessionId(),
              client_message: lastUser,
              ai_message: aiText
            })
          }).catch(err => console.error("Gagal menyimpan histori chat:", err));
        }

        if (aiText && chatMode === 'ai') {
          const cantHelp = /(tidak dapat membantu|tidak menemukan|saya tidak tahu|hubungi admin|silakan hubungi|tidak tersedia dalam data|di luar kemampuan)/i;
          if (cantHelp.test(aiText)) {
            showHandoverSuggestion();
          }
        }

        currentBotBubble = null;
        return;
      }
      appendStreamingText(event.data);
    };

    ws.onerror = (err) => {
      console.error("WS Error:", err);
      isStreaming = false;
    };

    ws.onclose = () => {
      ws = null;
      isStreaming = false;
    };
  }

  function appendStreamingText(chunk) {
    if (!currentBotBubble) return;
    currentBotBubble.textContent += chunk;
    
    let fullText = currentBotBubble.textContent;

    if (fullText.includes("[SYS_ADMIN_CONNECTED]")) {
        if (chatMode !== 'live') setChatMode('live');
        currentBotBubble.parentElement.style.display = 'none';
        removeWaitingBubble();
        if (!currentBotBubble.dataset.sig1) { 
            currentBotBubble.dataset.sig1="1"; 
            appendSystemBubble('✅ Admin telah terhubung. Anda sekarang berbicara dengan tim kami.'); 
        }
        return;
    }

    if (fullText.includes("[SYS_ADMIN_DISCONNECTED]")) {
        if (chatMode !== 'ai') setChatMode('ai');
        currentBotBubble.parentElement.style.display = 'none';
        removeWaitingBubble();
        if (!currentBotBubble.dataset.sig2) { 
            currentBotBubble.dataset.sig2="1"; 
            appendSystemBubble('Sesi dengan Admin telah berakhir. Anda kini kembali dilayani oleh AI Minara.'); 
        }
        return;
    }

    if (fullText.includes("[ADMIN] ")) {
        if (chatMode !== 'live') setChatMode('live');
        
        currentBotBubble.className = "chat-admin-bubble";
        const img = currentBotBubble.parentElement.querySelector('img');
        if(img) img.style.display = 'none';
        
        if (!currentBotBubble.parentElement.querySelector('.admin-cs-avatar')) {
             const avatar = document.createElement('div');
             avatar.className = 'admin-cs-avatar w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center shrink-0 shadow-sm text-amber-600 text-xs font-bold';
             avatar.textContent = 'CS';
             currentBotBubble.parentElement.insertBefore(avatar, currentBotBubble);
        }
        
        currentBotBubble.textContent = fullText.replace("[ADMIN] ", "");
        messages.scrollTo({ top: messages.scrollHeight, behavior: "smooth" });
        return;
    }

    if (chunk.includes("👨‍💼")) setChatMode('live');
    else if (chunk.includes("🤖")) setChatMode('ai');

    messages.scrollTo({ top: messages.scrollHeight, behavior: "smooth" });
  }

  function sendMessage() {
    const text = input.value.trim();
    hideMainMenu();
    sessionStorage.setItem("chatbotMenuShown", "true");
    if (!text || isStreaming) return;

    input.value = "";

    const userBubble = document.createElement("div");
    userBubble.classList.add("chat-user-bubble");
    userBubble.textContent = text;
    messages.appendChild(userBubble);

    const timeUser = document.createElement("div");
    timeUser.className = "chat-time-text chat-user-time";
    timeUser.textContent = getTimeStr();
    messages.appendChild(timeUser);

    if (chatMode === 'live' || chatMode === 'waiting') {
      messages.scrollTo({ top: messages.scrollHeight, behavior: "smooth" });
    } else {
      const chatRow = document.createElement("div");
      chatRow.className = "flex items-start gap-2 mb-1 mt-2";

      const avatar = document.createElement("img");
      avatar.src = "{{ asset('vendor/chatbot/icon-aranus.png') }}";
      avatar.onerror = function() { this.src = "/assets/icon-aranus.png"; };
      avatar.className = "w-8 h-8 rounded-full object-cover bg-white shrink-0 shadow-sm";

      currentBotBubble = document.createElement("div");
      currentBotBubble.classList.add("chat-ai-bubble");
      currentBotBubble.textContent = "";

      chatRow.appendChild(avatar);
      chatRow.appendChild(currentBotBubble);
      messages.appendChild(chatRow);

      const timeAI = document.createElement("div");
      timeAI.className = "chat-time-text chat-ai-time";
      timeAI.textContent = getTimeStr();
      messages.appendChild(timeAI);

      messages.scrollTo({ top: messages.scrollHeight, behavior: "smooth" });
      isStreaming = true;
    }

    const payload = { question: text, source: "aranus" };
    if (!ws || ws.readyState !== WebSocket.OPEN) { _pendingPayload = payload; connectWS(); return; }
    ws.send(JSON.stringify(payload));
  }

  (toggleWrap || toggleBtn).onclick = () => {
    if (welcomeCard) welcomeCard.style.display = "none";

    if (chatBox.classList.contains("hidden")) {
      chatBox.classList.remove("hidden");
      chatBox.classList.add("flex");
      
      setTimeout(() => {
        chatBox.classList.add("scale-100", "opacity-100");
        chatBox.classList.remove("scale-95", "opacity-0");
      }, 10);

      fetchPopularQuestions();
      
      if (haloBubble && !haloShownOnce) {
        haloBubble.classList.add("fade-in-up");
        haloShownOnce = true;
      }
      connectWS();
      setTimeout(() => input.focus(), 300);
    } else {
      chatBox.classList.remove("scale-100", "opacity-100");
      chatBox.classList.add("scale-95", "opacity-0");
      setTimeout(() => {
        chatBox.classList.remove("flex");
        chatBox.classList.add("hidden");
        disconnectWS();
      }, 300);
    }
  };

  closeBtn.onclick = () => {
    chatBox.classList.remove("scale-100", "opacity-100");
    chatBox.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
      chatBox.classList.remove("flex");
      chatBox.classList.add("hidden");
      disconnectWS();
    }, 300);
  };

  input.addEventListener("keypress", e => {
    if (e.key === "Enter") sendMessage();
  });

  sendBtn.onclick = () => sendMessage();

  if (handoverBar) {
    handoverBar.addEventListener('handover-click', () => requestHandover());
  }

  function requestHandover() {
    if (chatMode !== 'ai') return;
    
    setChatMode('waiting');

    const payload = { question: "chat admin", source: "aranus" }; 
    
    if (!ws || ws.readyState !== WebSocket.OPEN) { 
        _pendingPayload = payload; 
        connectWS(); 
        return; 
    }
    
    ws.send(JSON.stringify(payload));
    appendWaitingBubble();

    // Opsional: API untuk notifikasi email
    // const csrfToken = getCsrfToken();
    // fetch('/notify-admin-handover', { ... }); 
  }

  function handleSystemMessage(data) {
    if (data.type === 'admin_connected') {
      setChatMode('live');
      removeWaitingBubble();
      appendSystemBubble('✅ Admin telah terhubung. Anda sekarang berbicara dengan tim kami.');
    } else if (data.type === 'admin_message') {
      if (chatMode !== 'live') setChatMode('live');
      appendAdminBubble(data.message);
    } else if (data.type === 'admin_disconnected') {
      setChatMode('ai');
      removeWaitingBubble();
      appendSystemBubble('Sesi dengan Admin telah berakhir. Anda kini kembali dilayani oleh AI Minara.');
    } else if (data.type === 'handover_queued') {
      setChatMode('waiting');
    }
  }

  function setChatMode(mode) {
    chatMode = mode;
    if (!headerEl || !modeLabel || !waitingBanner || !handoverBar) return;

    modeLabel.classList.add('hidden');
    waitingBanner.classList.add('hidden');
    handoverBar.classList.remove('hidden-bar');

    if (mode === 'waiting') {
      waitingBanner.classList.remove('hidden');
      handoverBar.classList.add('hidden-bar');
    } else if (mode === 'live') {
      waitingBanner.classList.add('hidden');
      handoverBar.classList.add('hidden-bar');
    } else {
      handoverBar.classList.remove('hidden-bar');
    }
  }

  function appendSystemBubble(text) {
    const bubble = document.createElement('div');
    bubble.classList.add('chat-system-bubble');
    bubble.textContent = text;
    messages.appendChild(bubble);
    messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
  }

  function appendWaitingBubble() {
    removeWaitingBubble();
    const bubble = document.createElement('div');
    bubble.classList.add('chat-system-bubble');
    bubble.id = 'chatbot-waiting-bubble';
    bubble.textContent = '⏳ Permintaan Anda telah dikirim. Menunggu admin tersedia...';
    messages.appendChild(bubble);
    messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
  }

  function removeWaitingBubble() {
    const el = document.getElementById('chatbot-waiting-bubble');
    if (el) el.remove();
  }

  function appendAdminBubble(text) {
    const chatRow = document.createElement('div');
    chatRow.className = 'flex items-start gap-2 mb-1 mt-2';
    const avatar = document.createElement('div');
    avatar.className = 'w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center shrink-0 shadow-sm text-amber-600 text-xs font-bold';
    avatar.textContent = 'CS';
    const bubble = document.createElement('div');
    bubble.classList.add('chat-admin-bubble');
    bubble.textContent = text;
    chatRow.appendChild(avatar);
    chatRow.appendChild(bubble);
    messages.appendChild(chatRow);
    const timeEl = document.createElement('div');
    timeEl.className = 'chat-time-text chat-ai-time';
    timeEl.textContent = getTimeStr();
    messages.appendChild(timeEl);
    messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
  }

  function showHandoverSuggestion() {
    const suggest = document.createElement('div');
    suggest.className = 'chatbot-handover-suggest';
    suggest.innerHTML = `
      <div style="display:flex; align-items:center; gap:8px; padding:8px 12px; margin:8px 0 4px 2.5rem; background:#fff; border:1px solid #e5e7eb; border-radius:12px; cursor:pointer; transition:background 0.15s; max-width:fit-content;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='#fff'">
        <svg style="width:18px;height:18px;color:#00A86B;flex-shrink:0;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
        <span style="font-size:0.8rem;font-weight:600;color:#00A86B;">Chat dengan Admin</span>
      </div>
    `;
    messages.appendChild(suggest);
    suggest.querySelector('div').onclick = () => {
      suggest.remove();
      requestHandover();
    };
    messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
  }

});
</script>
@endpush