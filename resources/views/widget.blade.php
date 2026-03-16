<script>
  window.CHATBOT_WS_URL = @json(config('chatbot.ws_url'));
  console.log('CHATBOT_WS_URL =', window.CHATBOT_WS_URL);
</script>
<div id="chatbot-container">
  <!-- Toggle Logo -->
  <div id="chatbot-toggle-wrapper">
        <div class="gradient-border"></div> 
        <div class="white-bg"></div>        
        <img id="chatbot-toggle" src="/chatbot-icon" alt="Chatbot Logo">
  </div>
  <div id="chatbot-welcome-card">
    <p>Halo Client 👋<br>
  Saya <b>Minara</b> yang siap membantu jika Anda ingin mengetahui lebih lanjut tentang <b>Aranus Technology</b>.</p>
  </div>
  <div id="chatbot-box">
    <div class="card-header">
      <img id="chatbot-resize" src="/chatbot-icon" alt="Chatbot Logo">
      <span class="toggle-text">Minara Assistant</span>
      <button id="chatbot-close" type="button" class="btn btn-sm btn-light">×</button>
    </div>    
    <div id="chatbot-messages">
      <!-- Pesan pembuka dari AI -->
      <div class="chat-ai-row">
        <img class="chat-ai-avatar" src="/chatbot-icon" alt="Chatbot Logo">
        <div id="chatbot-halo-client" class="chat-ai chat-msg fade-in">
          Halo Client! 👋 Ada yang bisa saya bantu hari ini?
        </div>
      </div>
      <div id="chatbot-first-time" class="chat-time chat-ai-time"></div>
          <!-- Menu utama pertanyaan -->
    <div id="chatbot-main-menu" class="chat-main-menu">
      <div class="menu-title" style="font-weight:600;margin-bottom:8px;">🔥 Pertanyaan Populer</div>
      <!-- container yang benar: div dengan class menu-grid dan id popular-grid -->
    <div class="menu-grid" id="popular-grid">
      <button type="button"
              class="menu-item default-question"
              data-question="Apa saja layanan yang tersedia di Aranus Technology?">
        <span class="menu-icon">💬</span>
        <span><b>Apa saja layanan yang tersedia?</b></span>
      </button>
      <button type="button"
              class="menu-item default-question"
              data-question="Bagaimana cara menghubungi tim Aranus Technology?">
        <span class="menu-icon">💬</span>
        <span><b>Bagaimana cara menghubungi tim?</b></span>
      </button>
      <button type="button"
              class="menu-item default-question"
              data-question="Apakah Aranus Technology menyediakan konsultasi gratis?">
        <span class="menu-icon">💬</span>
        <span><b>Apakah tersedia konsultasi gratis?</b></span>
      </button>
      <button type="button"
              class="menu-item default-question"
              data-question="Bagaimana proses kerja sama dengan Aranus Technology?">
        <span class="menu-icon">💬</span>
        <span><b>Bagaimana proses kerja sama?</b></span>
      </button>
    </div>
    </div>
    </div>
    <div class="card-footer">
      <input type="text" id="chatbot-input" placeholder="Tulis pesan..." />
      <button id="chatbot-send-btn" type="button" title="Kirim Pesan">➤</button>
    </div>
  </div>
</div>

<style>
.fade-in {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.fade-in.show {
    opacity: 1;
    transform: translateY(0);
}
.menu-close {
    position: absolute;
    top: -1px; 
    right: 8px;
    background: transparent;
    border: none;
    color: rgba(179, 179, 179, 0.8);
    font-size: 20px;
    cursor: pointer;
    transition: color 0.2s ease;
    z-index: 10; 
}
.chat-main-menu {
  position: relative;
  text-align: center;
  color: #9e9e9e;
  background: transparent;
  border: 1.5px solid rgba(51, 51, 51, 0.87);
  border-radius: 10px;
    padding: 20px 12px 12px; 
    animation: fadeIn 0.4s ease;
  margin-top: 20px;
  padding: 28px 12px 12px;
    box-shadow: 
        0 8px 20px rgba(0,0,0,0.25), 
        inset 0 2px 6px rgba(255,255,255,0.15); 
  backdrop-filter: blur(6px);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    padding-bottom: 8px;
    
}
.chat-main-menu:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 12px 25px rgba(0,0,0,0.35),
        inset 0 2px 6px rgba(255,255,255,0.15);
}
.menu-title {
    font-size: 15px;
    margin-bottom: 12px;
    font-weight: 600;
    
}
.menu-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    margin-bottom: 0px;
}
.menu-icon {
    font-size: 20px;
    display: flex;
    align-items: center;
}
.menu-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px; 
    background: rgba(255,255,255,0.4);
    border: 1.6px solid rgb(23, 23, 23);
    color: #3c3c3c;
    border-radius: 20px;
    padding: 14px 16px;
    cursor: pointer;
    font-size: 15px;
    height: 90px;
    text-align: left;
    transition: all 0.2s ease;
}
.menu-item:hover {
    background: rgba(0, 0, 0, 0.2);
    
    color: #ffffff;
    transform: translateY(-2px);
}
.menu-note {
    font-size: 12px;
    opacity: 0.8;
}
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}
.chat-time {
    font-size: 10px;
    color: #888; 
    text-align: right;
    margin-top: 2px;
    display: block;
}
    #chatbot-close {
        background: transparent;
        border: none;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        color: white;
    }
.card-header {
        background: #2e2e2ecc;
        color: white;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
}
    #chatbot-container {
        position: fixed;
        bottom: 90px; 
        right: 30px;
        z-index: 9999;
    }
    .toggle-text {
        width: 100%;             
        padding-left: 10px;    
    }
#chatbot-toggle-wrapper {
    position: relative;
    width: 70px;
    height: 70px;
    cursor: pointer;
}
.gradient-border {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  border-radius: 50%;
  background: linear-gradient(45deg, #4da6ff, #b266ff);
  z-index: 1;
}

@keyframes spin360 {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.spin {
    animation: spin360 0.6s ease-in-out; 
}
.white-bg {
    position: absolute;
    top: 3px;   
    left: 3px;
    width: calc(100% - 6px);
    height: calc(100% - 6px);
    border-radius: 50%;
    background: #fff;
    z-index: 2;
}
#chatbot-toggle {
    position: absolute;
    top: 6px;   
    left: 6px;
    width: calc(100% - 12px);
    height: calc(100% - 12px);
    border-radius: 50%;
    object-fit: cover;
  z-index: 3;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

#chatbot-toggle-wrapper:hover #chatbot-toggle {
    transform: none; 
    box-shadow: 0 0 12px rgb(236, 196, 255); 
}
#chatbot-box {
  display: none;
        width: 90vw;         
        max-width: 500px;     
        height: 60vh;         
        max-height: 600px;    
        position: absolute;
        bottom: 70px;
        right: 0;
        border-radius: 12px;
        overflow: hidden;
        animation: fadeInUp 0.3s ease;
        background: transparent;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        border: 1px solid rgba(0,0,0,0.1);
        flex-direction: column;
        transition: width 0.3s ease, height 0.3s ease; 
    }
    #chatbot-box.show {
        display: flex;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
#chatbot-messages {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
}
.chat-msg {
    max-width: 75%;
    width: fit-content; 
    padding: 8px 12px;
    border-radius: 16px;
    word-wrap: break-word;
    font-size: 14px;
    line-height: 1.4;
    box-sizing: border-box;
}
    .chat-ai {
        background-color: #e4e4e4;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
    .chat-user {
        background-color: #304a40;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    #chatbot-box .card-footer {
        padding: 6px;
        background: transparent;
        border-top: 1px solid rgba(0, 73, 33, 0.27);
        display: flex;
        align-items: center;
        gap: 6px;
}
#chatbot-input {
    width: 100%;
    min-width: 0;
  border-radius: 20px;
  border: 1px solid rgba(0,0,0,0.2);
  padding: 6px 12px;
  outline: none;
  box-sizing: border-box;
  flex: 1;
  background: rgba(255,255,255,0.8);
}
#fast-question-btn, #chatbot-send-btn {
  background: rgba(255,255,255,0.2);
  border: none;
  border-radius: 50%;
    width: 32px;
    height: 32px;
  color: #333;
  cursor: pointer;
  transition: all 0.2s ease;
  backdrop-filter: blur(4px);
}
#fast-question-btn:hover, #chatbot-send-btn:hover {
    background: rgba(255,255,255,0.35);
}
#fast-question-card {
    position: absolute;
    bottom: 80px;
    left: 0;
    background: rgba(200, 200, 200, 0.13);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 8px;
    width: 230px;
    display: none;
    flex-direction: column;
    gap: 6px;
    animation: fadeInFastCard 0.25s ease;
}
@keyframes fadeInFastCard {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.fast-question-item {
    font-size: 13px;
    color: #333;
    padding: 6px 8px;
    border-radius: 6px;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.13);
    transition: all 0.2s ease;
}

.fast-question-item:hover {
    background: rgba(255,255,255,0.6);
}


#chatbot-resize {
    background-color: #fff;
    border-radius: 50%; 
    width: 40px;        
    height: 40px;       
    cursor: pointer;
    object-fit: contain; 
}


.chat-ai-row {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    margin-bottom: 2px;
    flex-wrap: wrap; 
}

.chat-ai-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    background-color: #fff;
    flex-shrink: 0;
}

.chat-time {
    font-size: 11px;
    color: #999;
    margin-bottom: 6px;
}

.chat-user-time {
    text-align: right; 
}

.chat-ai-time {
    text-align: left;  
}


#chatbot-welcome-card {
    position: absolute;
    bottom: 0;
    right: 0;
  transform: translate(-25px, -25px) rotate(30deg) scale(0.8);
    background: white;
    color: #333;
    font-size: 13px;
    line-height: 1.4;
    padding: 10px 14px;
    width: 255px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.15);
  z-index: 0;
    opacity: 0; 
    animation: welcomePop 0.8s ease-out forwards; }


@keyframes welcomePop {
    0% {
        transform: translate(-25px, 30px) rotate(30deg) scale(0.7);
        opacity: 0;
    }
    60% {
        transform: translate(-25px, -10px) rotate(10deg) scale(1.05);
        opacity: 0.9;
    }
    100% {
        transform: translate(-25px, -25px) rotate(0deg) scale(1);
        opacity: 1;
    }
}

  #chatbot-welcome-card p {
      margin: 0;
  }



#chatbot-messages::-webkit-scrollbar {
    width: 8px; 
}

#chatbot-messages::-webkit-scrollbar-track {
    background: transparent; 
    border-radius: 10px;
}

#chatbot-messages::-webkit-scrollbar-thumb {
    background: rgba(46, 46, 46, 0.5); 
    border-radius: 10px;
    backdrop-filter: blur(4px); }

#chatbot-messages::-webkit-scrollbar-thumb:hover {
    background: rgba(46, 46, 46, 0.7); 
}


#chatbot-messages {
    scrollbar-width: thin;
    scrollbar-color: rgba(46,46,46,0.5) transparent;
}


#chatbot-first-time {
    font-size: 10px;
    color: #aaa;
    margin-top: 2px;
    margin-left: 38px; 
}



</style>


<script>
document.addEventListener('DOMContentLoaded', () => {


  // ================== BIND MENU BUTTON ==================
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

// Jalankan saat pertama load untuk default HTML
bindMenuButtons();




  // Hindari inisialisasi ganda jika komponen ini muncul lebih dari sekali di halaman
  if (window.__aranus_chatbot_init) return;
  window.__aranus_chatbot_init = true;

  // Elemen utama
  const toggleBtn  = document.getElementById("chatbot-toggle");
  const toggleWrap = document.getElementById("chatbot-toggle-wrapper");
  const chatBox    = document.getElementById("chatbot-box");
  const closeBtn   = document.getElementById("chatbot-close");
  const input      = document.getElementById("chatbot-input");
  const messages   = document.getElementById("chatbot-messages");
  const firstTimeEl = document.getElementById("chatbot-first-time");
  const mainMenu   = document.getElementById("chatbot-main-menu");
  const welcomeCard = document.getElementById("chatbot-welcome-card");
  const sendBtn    = document.getElementById("chatbot-send-btn");
  const menuGrid   = document.getElementById("popular-grid");
  const haloBubble = document.getElementById("chatbot-halo-client");

  if (!toggleBtn || !chatBox || !closeBtn || !input || !messages || !sendBtn) return;

  let ws = null;
  let isStreaming = false;
  let currentBotBubble = null;
  let _pendingPayload = null;
  let _errorShown = false;
  let haloShownOnce = false;

  // ------------------ Fungsi umum ------------------
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



// ------------------ Ambil pertanyaan populer ------------------
async function fetchPopularQuestions() {
  if (!menuGrid) return;

  // Default questions (hardcoded fallback)
  const defaultQuestions = [
    "Apa saja layanan yang tersedia di Aranus Technology?",
    "Bagaimana cara menghubungi tim Aranus Technology?",
    "Apakah Aranus Technology menyediakan konsultasi gratis?",
    "Bagaimana proses kerja sama dengan Aranus Technology?"
  ];

  try {
    const res = await fetch('/popular-questions');
    if (!res.ok) throw new Error('Gagal memuat');

    const data = await res.json();

    let dbQuestions = [];

    if (Array.isArray(data) && data.length > 0) {
      dbQuestions = data
        .map(item => item.client_message?.trim())
        .filter(q => q && q.length > 0);
    }

    // Gabungkan DB + default
    const finalQuestions = [...dbQuestions];

    // Tambahkan default jika masih kurang dari 4
    for (let i = 0; finalQuestions.length < 4 && i < defaultQuestions.length; i++) {
      if (!finalQuestions.includes(defaultQuestions[i])) {
        finalQuestions.push(defaultQuestions[i]);
      }
    }

    // Batasi maksimal 4
    const limitedQuestions = finalQuestions.slice(0, 4);

    // Render ulang grid
    menuGrid.innerHTML = '';

    limitedQuestions.forEach(text => {
      const btn = document.createElement('button');
      btn.classList.add('menu-item');
      btn.type = 'button';
      btn.dataset.question = text;

      btn.innerHTML = `
        <span class="menu-icon">💬</span>
        <span><b>${text}</b></span>
      `;

      menuGrid.appendChild(btn);
    });

    // Re-bind setelah inject
    bindMenuButtons();

  } catch (err) {
    console.warn('⚠️ API gagal, menggunakan default popular questions.');
    // Kalau API error → jangan ubah apapun (default HTML tetap ada)
  }
}

  // ------------------ WebSocket logic ------------------
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
    if (!wsUrl || typeof wsUrl !== "string") {
      console.warn("⚠️ CHATBOT_WS_URL belum dikonfigurasi.");
      return;
    }

    ws = new WebSocket(wsUrl);

    ws.onopen = () => {
      console.log("✅ WS Connected:", wsUrl);
      if (_pendingPayload) {
        ws.send(JSON.stringify(_pendingPayload));
        _pendingPayload = null;
      }
    };

    ws.onmessage = (event) => {
      if (event.data === "[END]") {
        isStreaming = false;

        const aiText = currentBotBubble ? currentBotBubble.textContent.trim() : "";
        const userBubbles = document.querySelectorAll(".chat-user");
        const lastUser = userBubbles[userBubbles.length - 1]?.textContent || "";

        if (aiText && lastUser) {
          fetch("{{ route('chat.store') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
            },
            body: JSON.stringify({
              session_code: sessionStorage.getItem("chat_session_code") || generateSessionId(),
              client_message: lastUser,
              ai_message: aiText
            })
          });
        }

        currentBotBubble = null;
        return;
      }
 
      appendStreamingText(event.data);
    };

    ws.onerror = (err) => {
      console.error("❌ WS Error:", err);
      isStreaming = false;
    };

    ws.onclose = () => {
      console.log("🔌 WS Closed");
      ws = null;
      isStreaming = false;
    };
  }

  function appendStreamingText(chunk) {
    if (!currentBotBubble) return;
    currentBotBubble.textContent += chunk;
    messages.scrollTo({ top: messages.scrollHeight, behavior: "smooth" });
  }

  // ------------------ Kirim pesan ------------------
  function sendMessage() {
    const text = input.value.trim();
    hideMainMenu();
    sessionStorage.setItem("chatbotMenuShown", "true");
    if (!text || isStreaming) return;

    input.value = "";
    _errorShown = false;

    // Bubble user
    const userBubble = document.createElement("div");
    userBubble.classList.add("chat-msg", "chat-user");
    userBubble.textContent = text;
    messages.appendChild(userBubble);

    const timeUser = document.createElement("div");
    timeUser.classList.add("chat-time", "chat-user-time");
    timeUser.textContent = getTimeStr();
    messages.appendChild(timeUser);

    // Bubble bot placeholder
    const chatRow = document.createElement("div");
    chatRow.classList.add("chat-ai-row");

    const avatar = document.createElement("img");
    avatar.src = "/chatbot-icon";
    avatar.classList.add("chat-ai-avatar");

    currentBotBubble = document.createElement("div");
    currentBotBubble.classList.add("chat-msg", "chat-ai");
    currentBotBubble.textContent = "";

    chatRow.appendChild(avatar);
    chatRow.appendChild(currentBotBubble);
    messages.appendChild(chatRow);

    const timeAI = document.createElement("div");
    timeAI.classList.add("chat-time", "chat-ai-time");
    timeAI.textContent = getTimeStr();
    messages.appendChild(timeAI);

    messages.scrollTo({ top: messages.scrollHeight, behavior: "smooth" });
    isStreaming = true;

    // Kirim ke server WebSocket
    const payload = { question: text, source: "aranus" };
    if (!ws || ws.readyState !== WebSocket.OPEN) {
      _pendingPayload = payload;
      connectWS();
      return;
    }
    ws.send(JSON.stringify(payload));
  }

  // ------------------ Toggle & event listeners ------------------
  (toggleWrap || toggleBtn).onclick = () => {
    const border = document.querySelector("#chatbot-toggle-wrapper .gradient-border");
    if (border) {
      border.classList.remove("spin");
      void border.offsetWidth;
      border.classList.add("spin");
    }

    chatBox.classList.toggle("show");

    if (chatBox.classList.contains("show")) {
      fetchPopularQuestions(); // Ambil pertanyaan populer setiap kali dibuka

      // Tampilkan halo message dengan efek lembut
      if (haloBubble && !haloShownOnce) {
        haloBubble.classList.add("show"); 
        haloShownOnce = true;
      }

      if (welcomeCard) welcomeCard.style.display = "none";
      connectWS();
      setTimeout(() => input.focus(), 0);
    } else {
      disconnectWS();
    }
  };

  closeBtn.onclick = () => {
    chatBox.classList.remove("show");
    disconnectWS();
  };

  input.addEventListener("keypress", e => {
    if (e.key === "Enter") sendMessage();
  });

  sendBtn.onclick = () => sendMessage();

  // Tampilkan pesan pembuka langsung saat halaman load (tanpa menunggu klik)
  if (haloBubble) {
    haloBubble.classList.add("show");
  }
});
</script>

