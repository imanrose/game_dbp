<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ular, Tangga & Si Bulus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- LOTTIE PLAYER -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- FONT GAME -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Tema Warna Asal yang Dikekalkan */
            --sky-blue: #61D8F9;
            --grass-green: #A9E868;
            --btn-pink: #F2629E;
            --btn-pink-shadow: #D2427E;
            --btn-yellow: #FFD54F;
            --btn-yellow-shadow: #DCA92D;
            --text-dark: #2D4059;
            
            /* Warna Petak / Board Baru */
            --cell-pink-light: #FFF0F5;
            --cell-pink-border: #FFB6C1;
            --cell-pink-shadow: #FF9EAE;
            --cell-white: #FFFFFF;
            --cell-white-border: #EAF6F9;
            --board-bg: #FFFFFF;

            /* Warna Butang Keluar */
            --btn-red: #ff4757;
            --btn-red-shadow: #ff0000;
        }
        
        body { 
            /* Latar Belakang Horizon Biru ke Hijau */
            background-color: var(--sky-blue);
            background-image: linear-gradient(180deg, #61D8F9 0%, #85E0FA 45%, #A9E868 45%, #90D646 100%);
            background-attachment: fixed;
            color: var(--text-dark); 
            font-family: 'Nunito', sans-serif; 
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .font-game { font-family: 'Fredoka One', cursive; letter-spacing: 1px; }

        /* Awan, Burung & Matahari Animasi */
        .cloud { position: fixed; z-index: 0; opacity: 0.85; animation: drift linear infinite; pointer-events: none;}
        .bird { position: fixed; z-index: 0; animation: fly linear infinite; pointer-events: none;}
        @keyframes drift { 0% { transform: translateX(-30vw); } 100% { transform: translateX(120vw); } }
        @keyframes fly { 0% { transform: translate(-10vw, 10vh); } 50% { transform: translate(50vw, 5vh) translateY(-30px); } 100% { transform: translate(120vw, 15vh); } }
        @keyframes spin-slow { 100% { transform: rotate(360deg); } }

        /* Papan Utama - Solid White Card */
        .board-grid { 
            display: grid; grid-template-columns: repeat(10, 1fr); gap: 8px; 
            background: var(--board-bg); 
            padding: 20px; 
            border-radius: 36px; /* Super membulat */
            box-shadow: 0 16px 0 rgba(0, 0, 0, 0.05), 0 24px 30px rgba(0, 0, 0, 0.1); /* Bayang tebal di bawah */
            position: relative; z-index: 10;
        }
        
        /* Petak Dam */
        .board-cell { 
            aspect-ratio: 1; position: relative; 
            display: flex; align-items: center; justify-content: center; 
            border-radius: 14px; /* Sedikit petak membulat ala app */
            background-color: var(--cell-pink-light);
            border: 4px solid var(--cell-pink-border);
            box-shadow: 0 6px 0 var(--cell-pink-shadow); 
            transition: all 0.2s ease-in-out; 
            color: var(--btn-pink-shadow);
        }
        .board-cell:nth-child(even) { 
            background-color: var(--cell-white); 
            border-color: var(--cell-white-border);
            box-shadow: 0 6px 0 #DDF1F6;
            color: #FF69B4;
        }
        .board-cell:hover {
            transform: translateY(-3px); 
            box-shadow: 0 9px 0 #FF69B4, 0 15px 15px rgba(0,0,0,0.1); 
            z-index: 5;
        }
        
        .cat-token { 
            position: absolute; width: 95%; height: 95%; font-size: 1.5rem; 
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); 
            z-index: 20; display: flex; justify-content: center; align-items: center; 
            pointer-events: none; filter: drop-shadow(0 5px 4px rgba(0,0,0,0.3));
        }
        
        @keyframes floatItem { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-5px) rotate(3deg); filter: drop-shadow(0 6px 4px rgba(0,0,0,0.2)); } }
        .item-float { animation: floatItem 3s infinite ease-in-out; }

        /* Butang Timbul - Ditukar menjadi Rounded-2xl (Chunky rectangle) */
        .btn-pink { background-color: var(--btn-pink); color: white; border-bottom: 8px solid var(--btn-pink-shadow); transition: all 0.1s; border-radius: 24px; }
        .btn-pink:active { transform: translateY(8px); border-bottom: 0px solid var(--btn-pink-shadow); margin-bottom: 8px; }
        .btn-yellow { background-color: var(--btn-yellow); color: var(--text-dark); border-bottom: 8px solid var(--btn-yellow-shadow); transition: all 0.1s; border-radius: 24px; }
        .btn-yellow:active { transform: translateY(8px); border-bottom: 0px solid var(--btn-yellow-shadow); margin-bottom: 8px; }

        /* Butang Keluar Lobi */
        .btn-red-modal { background-color: var(--btn-red); color: white; border-bottom: 8px solid var(--btn-red-shadow); border-radius: 24px; transition: all 0.1s; display: flex; justify-content: center; align-items: center; }
        .btn-red-modal:active { transform: translateY(8px); border-bottom: 0px solid var(--btn-red-shadow); margin-bottom: 8px; }

        /* Butang Keluar Atas Kiri (Bentuk Bulat 3D) */
        .btn-exit-top {
            position: fixed;
            top: 20px; left: 20px;
            background-color: var(--btn-red);
            color: white;
            border-bottom: 6px solid var(--btn-red-shadow);
            border-radius: 50%;
            width: 55px; height: 55px;
            display: flex; justify-content: center; align-items: center;
            font-size: 1.5rem; font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.1s;
            z-index: 50;
            text-decoration: none;
        }
        .btn-exit-top:active {
            transform: translateY(6px);
            border-bottom-width: 0px;
            margin-bottom: 6px;
        }

        @keyframes victoryBounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-25px) scale(1.1); } }
        @keyframes panicShake { 0%, 100% { transform: translateX(0); filter: drop-shadow(0 0 0 transparent); } 20%, 60% { transform: translateX(-8px) rotate(-10deg); filter: drop-shadow(0 0 15px #ef4444); } 40%, 80% { transform: translateX(8px) rotate(10deg); filter: drop-shadow(0 0 15px #ef4444); } }
        .anim-bounce { animation: victoryBounce 0.4s ease-in-out 3; }
        .anim-fluff { animation: panicShake 0.6s ease-in-out 1; }
    </style>
</head>
<body class="py-8 px-4 flex flex-col items-center min-h-screen">

    <!-- Butang Keluar ke Lobi -->
    <a href="{{ route('peribahasa.lobby') }}" class="btn-exit-top" title="Keluar ke Menu Utama">
        ✖
    </a>

    <!-- Animasi Dekorasi Latar Belakang (Kekal) -->
    <div class="fixed top-4 right-10 text-[120px] z-0 drop-shadow-xl" style="animation: spin-slow 30s linear infinite;">☀️</div>
    <div class="cloud text-8xl top-10" style="animation-duration: 40s;">☁️</div>
    <div class="cloud text-9xl top-32" style="animation-duration: 25s; animation-delay: 5s;">☁️</div>
    <div class="bird text-6xl top-40" style="animation-duration: 18s;">🕊️</div>
    <div class="bird text-7xl top-20" style="animation-duration: 22s; animation-delay: 8s;">🦅</div>
    <div class="fixed bottom-0 left-4 text-[160px] z-0 drop-shadow-2xl">🏡🌳</div>

    <header class="text-center mb-6 w-full max-w-4xl relative z-10 mt-6 md:mt-0">
        <h1 class="font-game text-5xl md:text-6xl text-[#FFFFFF] mb-4 uppercase tracking-widest" style="-webkit-text-stroke: 3px #F2629E; text-shadow: 0 6px 0 rgba(0,0,0,0.1);">
            Ular, Tangga <br><span class="text-[#FFD54F]" style="-webkit-text-stroke: 3px #DCA92D;">& Si Bulus</span>
        </h1>
        
        <!-- Papan Markah direka bentuk bulat seakan bar atas app (Top Bar UI) -->
        <div class="inline-flex gap-4 justify-center bg-white/90 backdrop-blur-sm px-6 py-3 rounded-[24px] shadow-[0_8px_0_rgba(0,0,0,0.05)] border-4 border-white">
            <div class="px-5 py-2 bg-[#F8FDFE] text-[#D2427E] rounded-[16px] font-black text-xl border-2 border-[#EAF6F9]">Markah: <span id="scoreDisplay" class="text-[#F2629E]">{{ session('sl_score', 0) }}</span></div>
            <div class="px-5 py-2 bg-[#F8FDFE] text-[#D2427E] rounded-[16px] font-black text-xl border-2 border-[#EAF6F9]">Petak: <span id="posDisplay" class="text-[#F2629E]">{{ session('sl_position', 1) }}</span></div>
        </div>
    </header>

    <main class="w-full max-w-4xl relative z-10 flex flex-col items-center">
        <!-- Papan Solid Putih -->
        <div class="board-grid relative w-full" id="gameBoard">
            <div id="playerToken" class="cat-token">
                <lottie-player src="{{ asset('images/kucing-3d.json') }}" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div> 
        </div>

        <!-- Butang-butang Tebal (Chunky Buttons) -->
        <div class="mt-10 flex justify-center items-center gap-6 relative z-10 w-full max-w-2xl bg-white/80 p-4 rounded-[32px] shadow-[0_8px_0_rgba(0,0,0,0.05)]">
            <!-- Kotak Paparan Dadu -->
            <div id="diceDisplay" class="hidden bg-white w-20 h-20 rounded-[20px] border-4 border-[#2D4059] shadow-[0_6px_0_#CBD5E1] items-center justify-center p-2 transition-all shrink-0">
                <!-- SVG Dadu -->
            </div>

            <button id="btnRoll" class="btn-pink font-game w-full py-4 text-2xl flex items-center justify-center gap-3">
                🎲 BALING DADU
            </button>

            <a href="{{ route('peribahasa.ular', ['reset' => 1]) }}" class="btn-yellow font-game w-full py-4 text-2xl flex items-center justify-center gap-2 text-center">
                🔄 RESET
            </a>
        </div>
    </main>

    <!-- Modal Soalan (UI Putih Solid) -->
    <div id="questionModal" class="fixed inset-0 bg-[#2D4059]/60 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-[40px] p-8 max-w-lg w-full text-center shadow-[0_16px_0_rgba(0,0,0,0.2)]">
            <div class="text-6xl mb-2" id="modalIcon">⚠️</div>
            <h2 class="font-game text-4xl text-[#F2629E] mb-2" id="modalTitle">Halangan!</h2>
            <p class="text-xl font-bold text-[#2D4059] bg-[#F8FDFE] border-4 border-[#EAF6F9] p-6 rounded-[24px] mb-6" id="kluText"></p>
            
            <div class="flex flex-col gap-4" id="optionsContainer"></div>
        </div>
    </div>

    <!-- Modal Permainan Tamat -->
    <div id="gameOverModal" class="fixed inset-0 bg-[#2D4059]/80 backdrop-blur-sm hidden items-center justify-center z-[60]">
        <div class="bg-white rounded-[40px] p-10 max-w-lg w-full text-center shadow-[0_16px_0_rgba(0,0,0,0.2)]">
            <div class="text-8xl mb-4">🏆</div>
            <h2 class="font-game text-5xl text-[#F2629E] mb-2">Permainan Tamat!</h2>
            <p class="text-xl font-bold text-[#2D4059] mb-6">Tahniah! Si Bulus dah berjaya sampai ke petak 100!</p>
            
            <div class="bg-[#F8FDFE] p-6 rounded-[30px] mb-8 border-4 border-[#EAF6F9]">
                <p class="text-2xl text-[#2D4059] font-black">Markah Akhir: <br><span id="finalScoreDisplay" class="text-6xl text-[#FFD54F]" style="-webkit-text-stroke: 2px #DCA92D;">0</span></p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('peribahasa.ular', ['reset' => 1]) }}" class="w-full btn-yellow font-game px-6 py-4 text-xl shadow-sm text-center">
                    🔄 MAIN SEMULA
                </a>
                <a href="{{ route('peribahasa.lobby') }}" class="w-full btn-red-modal font-game px-6 py-4 text-xl shadow-sm text-center">
                    ✖ KELUAR LOBI
                </a>
            </div>
        </div>
    </div>

    <!-- Mesej Pop-Up Kecil (Toast) -->
    <div id="resultToast" class="fixed top-20 right-10 bg-white border-4 border-[#F2629E] text-[#D2427E] font-black px-6 py-4 rounded-[20px] shadow-2xl transition-all transform translate-x-[150%] z-[70] flex items-center gap-3">
        <span id="toastIcon" class="text-3xl">🔔</span>
        <span id="toastMessage" class="text-lg">Mesej di sini</span>
    </div>

    <script>
        const boardEl = document.getElementById('gameBoard');
        const token = document.getElementById('playerToken');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        
        let currentPos = {{ session('sl_position', 1) }};
        let pendingEvent = null;
        let currentQuestionId = null;
        let isMoving = false; // Elak tekan bertubi-tubi

        function initBoard() {
            const ladders = {3:22, 5:8, 11:26, 20:29, 27:84, 40:59, 51:67, 71:91};
            const snakes = {17:4, 19:7, 54:34, 64:60, 87:24, 93:73, 95:75, 99:78};
            
            for (let row = 9; row >= 0; row--) {
                for (let col = 0; col < 10; col++) {
                    let num = (row % 2 === 0) ? (row * 10) + col + 1 : (row * 10) + 10 - col;
                    const cell = document.createElement('div');
                    cell.className = 'board-cell'; 
                    cell.id = 'cell-' + num;
                    
                    let innerHTML = `<div class="absolute top-2 left-3 text-[14px] opacity-40 font-black z-0">${num}</div>`;
                    
                    if (ladders[num]) { innerHTML += `<div class="absolute inset-0 flex items-center justify-center opacity-100 text-5xl sm:text-6xl z-0 item-float">🪜</div>`; }
                    if (snakes[num]) { innerHTML += `<div class="absolute inset-0 flex items-center justify-center opacity-100 text-5xl sm:text-6xl z-0 item-float">🐍</div>`; }
                    
                    cell.innerHTML = innerHTML;
                    boardEl.appendChild(cell);
                }
            }
            updateTokenPosition(currentPos);
            checkGameOver(currentPos); 
        }

        function updateTokenPosition(pos) {
            const targetCell = document.getElementById('cell-' + pos);
            if(targetCell) { targetCell.appendChild(token); document.getElementById('posDisplay').innerText = pos; }
        }

        function showToast(icon, message) {
            const toast = document.getElementById('resultToast');
            document.getElementById('toastIcon').innerText = icon;
            document.getElementById('toastMessage').innerText = message;
            toast.style.transform = 'translateX(0)';
            setTimeout(() => { toast.style.transform = 'translateX(150%)'; }, 4000);
        }

        function checkGameOver(pos, score = {{ session('sl_score', 0) }}) {
            if (pos >= 100) {
                setTimeout(() => {
                    document.getElementById('gameOverModal').classList.remove('hidden');
                    document.getElementById('gameOverModal').classList.add('flex');
                    document.getElementById('finalScoreDisplay').innerText = score;
                    confetti({ particleCount: 150, spread: 100, origin: { y: 0.6 } });
                }, 800);
            }
        }

        function playSound(type) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator(); const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                
                if (type === 'roll') { osc.type = 'sine'; osc.frequency.setValueAtTime(400, ctx.currentTime); osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.1); gain.gain.setValueAtTime(0.1, ctx.currentTime); gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1); osc.start(); osc.stop(ctx.currentTime + 0.1); }
                else if (type === 'win') { osc.type = 'square'; osc.frequency.setValueAtTime(300, ctx.currentTime); osc.frequency.setValueAtTime(400, ctx.currentTime + 0.1); osc.frequency.setValueAtTime(500, ctx.currentTime + 0.2); osc.frequency.setValueAtTime(600, ctx.currentTime + 0.3); osc.frequency.setValueAtTime(800, ctx.currentTime + 0.4); gain.gain.setValueAtTime(0.1, ctx.currentTime); gain.gain.linearRampToValueAtTime(0, ctx.currentTime + 0.6); osc.start(); osc.stop(ctx.currentTime + 0.6); }
                else if (type === 'lose') { osc.type = 'sawtooth'; osc.frequency.setValueAtTime(400, ctx.currentTime); osc.frequency.exponentialRampToValueAtTime(50, ctx.currentTime + 0.6); gain.gain.setValueAtTime(0.15, ctx.currentTime); gain.gain.linearRampToValueAtTime(0, ctx.currentTime + 0.6); osc.start(); osc.stop(ctx.currentTime + 0.6); }
            } catch(e) {}
        }

        document.getElementById('btnRoll').addEventListener('click', () => {
            if (currentPos >= 100 || isMoving) return; 
            isMoving = true; 

            playSound('roll');
            fetch('/ular-tangga/roll', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf } })
            .then(res => res.json())
            .then(data => {
                if (data.error) { alert(data.error); isMoving = false; return; }
                
                // SVG Dadu Titik 
                const diceSVG = {
                    1: '<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md"><circle cx="50" cy="50" r="14" fill="#2D4059"/></svg>',
                    2: '<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md"><circle cx="25" cy="25" r="14" fill="#2D4059"/><circle cx="75" cy="75" r="14" fill="#2D4059"/></svg>',
                    3: '<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md"><circle cx="20" cy="20" r="14" fill="#2D4059"/><circle cx="50" cy="50" r="14" fill="#2D4059"/><circle cx="80" cy="80" r="14" fill="#2D4059"/></svg>',
                    4: '<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md"><circle cx="25" cy="25" r="14" fill="#2D4059"/><circle cx="75" cy="25" r="14" fill="#2D4059"/><circle cx="25" cy="75" r="14" fill="#2D4059"/><circle cx="75" cy="75" r="14" fill="#2D4059"/></svg>',
                    5: '<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md"><circle cx="20" cy="20" r="14" fill="#2D4059"/><circle cx="80" cy="20" r="14" fill="#2D4059"/><circle cx="50" cy="50" r="14" fill="#2D4059"/><circle cx="20" cy="80" r="14" fill="#2D4059"/><circle cx="80" cy="80" r="14" fill="#2D4059"/></svg>',
                    6: '<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md"><circle cx="25" cy="18" r="12" fill="#2D4059"/><circle cx="75" cy="18" r="12" fill="#2D4059"/><circle cx="25" cy="50" r="12" fill="#2D4059"/><circle cx="75" cy="50" r="12" fill="#2D4059"/><circle cx="25" cy="82" r="12" fill="#2D4059"/><circle cx="75" cy="82" r="12" fill="#2D4059"/></svg>'
                };
                const diceEl = document.getElementById('diceDisplay');
                diceEl.innerHTML = diceSVG[data.dice];
                diceEl.classList.remove('hidden');
                diceEl.classList.add('flex', 'anim-bounce');
                setTimeout(() => diceEl.classList.remove('anim-bounce'), 500);
                
                // Pergerakan Kucing 
                let targetPos = data.newPos;
                if (currentPos >= targetPos) { 
                    isMoving = false;
                    if (data.hasEvent) { setTimeout(() => triggerModal(data.eventType, data.soalan), 800); }
                    return;
                }

                let stepInterval = setInterval(() => {
                    currentPos++;
                    updateTokenPosition(currentPos);
                    if (currentPos >= targetPos) {
                        clearInterval(stepInterval); 
                        isMoving = false; 
                        if (data.hasEvent) { setTimeout(() => triggerModal(data.eventType, data.soalan), 600); }
                    }
                }, 350); 
            })
            .catch(err => { console.error("Ralat:", err); isMoving = false; });
        });

        function triggerModal(type, soalan) {
            pendingEvent = type; currentQuestionId = soalan.id;
            const modal = document.getElementById('questionModal');
            
            if (type === 'ladder') {
                document.getElementById('modalTitle').innerText = 'Peluang Naik Tangga!';
                document.getElementById('modalTitle').className = 'font-game text-4xl text-[#61D8F9] mb-2';
                document.getElementById('modalIcon').innerText = '🚀';
            } else if (type === 'snake') {
                document.getElementById('modalTitle').innerText = 'Awas! Kepala Ular!';
                document.getElementById('modalTitle').className = 'font-game text-4xl text-[#F2629E] mb-2';
                document.getElementById('modalIcon').innerText = '🐍';
            } else {
                document.getElementById('modalTitle').innerText = 'Uji Minda!';
                document.getElementById('modalTitle').className = 'font-game text-4xl text-[#FFD54F] mb-2';
                document.getElementById('modalIcon').innerText = '💡';
            }

            document.getElementById('kluText').innerText = soalan.klu;
            const optionsContainer = document.getElementById('optionsContainer');
            optionsContainer.innerHTML = '';
            
            soalan.pilihan.forEach(pil => {
                const btn = document.createElement('button');
                btn.className = 'btn-pink w-full py-4 px-6 rounded-[24px] font-game text-xl transition-all';
                btn.innerText = pil;
                btn.onclick = () => submitAnswer(pil);
                optionsContainer.appendChild(btn);
            });
            modal.classList.remove('hidden'); modal.classList.add('flex');   
        }

        function submitAnswer(jawapanPilihan) {
            fetch('/ular-tangga/answer', {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ soalan_id: currentQuestionId, jawapan: jawapanPilihan, event_type: pendingEvent })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('questionModal').classList.add('hidden');
                document.getElementById('questionModal').classList.remove('flex');
                
                showToast(data.isCorrect ? '✅' : '❌', data.mesej);
                
                if(data.isCorrect) {
                    playSound('win'); token.classList.add('anim-bounce'); 
                    confetti({ particleCount: 50, spread: 60, colors: ['#F2629E', '#FFD54F', '#61D8F9'] });
                } else {
                    playSound('lose'); token.classList.add('anim-fluff'); 
                }

                setTimeout(() => {
                    token.classList.remove('anim-bounce', 'anim-fluff');
                    currentPos = data.finalPos; updateTokenPosition(data.finalPos);
                    document.getElementById('scoreDisplay').innerText = data.score;
                    checkGameOver(data.finalPos, data.score);
                }, 1500);
            });
        }

        initBoard();
    </script>
</body>
</html>