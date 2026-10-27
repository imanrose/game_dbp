<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Uji Minda: Teka Peribahasa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Kalam:wght@700&family=Nunito:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            /* Tema Warna Baru: Kucing Comel & Kayu */
            --bg-color: #E2F0F9;       /* Biru pastel sangat cair */
            --wood-frame: #D4A373;     /* Warna Kayu Terang */
            --wood-frame-shadow: #A3704C;
            --paper-bg: #FFFDF7;       /* Putih Cream */
            
            --btn-pink: #F2629E;
            --btn-pink-shadow: #D2427E;
            --btn-yellow: #FFD54F;
            --btn-yellow-shadow: #DCA92D;
            --btn-blue: #61D8F9;
            --btn-blue-shadow: #3BA9C9;
            --btn-green: #A9E868;
            --btn-green-shadow: #82C83C;
            --btn-red: #E85F6B;
            --btn-red-shadow: #BE4D58;
            
            --text-dark: #3E2723;      /* Coklat gelap */
        }

        /* Latar Belakang dengan CSS Paw Prints Pattern */
        body { 
            background-color: var(--bg-color); 
            background-image: radial-gradient(#B3D4E5 2px, transparent 2px);
            background-size: 30px 30px;
            color: var(--text-dark); 
            font-family: 'Nunito', sans-serif; 
            min-height: 100vh; 
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .font-game { font-family: 'Fredoka One', cursive; letter-spacing: 1px; }
        .font-handwriting { font-family: 'Kalam', cursive; }

        /* Animasi Dekorasi paw Kucing Terapung */
        .floating-paw { position: fixed; z-index: 0; opacity: 0.15; animation: floatUp linear infinite; pointer-events: none; font-size: 4rem; }
        @keyframes floatUp { 
            0% { transform: translateY(110vh) rotate(0deg) scale(0.8); opacity: 0; } 
            20% { opacity: 0.2; }
            80% { opacity: 0.2; }
            100% { transform: translateY(-10vh) rotate(360deg) scale(1.2); opacity: 0; } 
        }

        /* Butang Keluar Atas Kiri (Bentuk Bulat 3D) */
        .btn-exit-top {
            position: absolute;
            top: 20px; left: 20px;
            background-color: var(--btn-red);
            color: white;
            border-bottom: 6px solid var(--btn-red-shadow);
            border-radius: 50%;
            width: 50px; height: 50px;
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

        /* Papan Kayu Kucing */
        .cute-board {
            background-color: var(--paper-bg);
            border: 12px solid var(--wood-frame); 
            border-radius: 32px;
            box-shadow: 
                0 15px 0 var(--wood-frame-shadow), 
                0 25px 30px rgba(0,0,0,0.15), 
                inset 0 0 0 6px rgba(255,255,255,0.8); 
            width: 100%;
            max-w: 900px;
            position: relative;
            z-index: 10;
        }
        
        /* Pin di sudut papan */
        .cute-board::before, .cute-board::after {
            content: ''; position: absolute; top: 15px; width: 16px; height: 16px; 
            background-color: #E74C3C; border-radius: 50%; 
            box-shadow: inset -3px -3px 0 rgba(0,0,0,0.2), 2px 4px 4px rgba(0,0,0,0.2);
        }
        .cute-board::before { left: 15px; }
        .cute-board::after { right: 15px; }

        /* Animasi Lap Papan */
        .wipe-animation { animation: wipeBoard 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        @keyframes wipeBoard {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(0.95); opacity: 0.5; filter: blur(2px); }
            100% { transform: scale(1); opacity: 1; filter: blur(0); }
        }

        /* Butang Timbul 3D (Chunky Buttons) */
        .chunky-btn {
            font-family: 'Fredoka One', cursive;
            font-size: 1.15rem;
            padding: 1.5rem;
            border-radius: 24px;
            transition: all 0.1s ease-in-out;
            cursor: pointer;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100px;
            line-height: 1.3;
        }
        
        .chunky-btn:active {
            transform: translateY(8px);
            margin-bottom: 8px;
            border-bottom-width: 0px !important;
        }

        /* Warna Butang Dinamik */
        .btn-color-1 { background-color: var(--btn-pink); border-bottom: 8px solid var(--btn-pink-shadow); color: white; text-shadow: 0 2px 0 rgba(0,0,0,0.1); }
        .btn-color-2 { background-color: var(--btn-yellow); border-bottom: 8px solid var(--btn-yellow-shadow); color: var(--text-dark); }
        .btn-color-3 { background-color: var(--btn-blue); border-bottom: 8px solid var(--btn-blue-shadow); color: white; text-shadow: 0 2px 0 rgba(0,0,0,0.1); }
        .btn-color-4 { background-color: var(--btn-green); border-bottom: 8px solid var(--btn-green-shadow); color: var(--text-dark); }

        .chunky-btn:hover { filter: brightness(1.05); }

        /* Bintang di Akhir Game */
        .star-icon { font-size: 5.5rem; color: #dfe6e9; transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .star-earned { color: #FFD54F; transform: scale(1.2) rotate(10deg); text-shadow: 0 0 20px rgba(255, 213, 79, 0.8); }

        /* Butang Modal Umum */
        .btn-yellow-modal { background-color: var(--btn-yellow); color: var(--text-dark); border-bottom: 8px solid var(--btn-yellow-shadow); border-radius: 24px; transition: all 0.1s; }
        .btn-yellow-modal:active { transform: translateY(8px); border-bottom: 0px; margin-bottom: 8px; }
        .btn-blue-modal { background-color: var(--btn-blue); color: white; border-bottom: 8px solid var(--btn-blue-shadow); border-radius: 24px; transition: all 0.1s; }
        .btn-blue-modal:active { transform: translateY(8px); border-bottom: 0px; margin-bottom: 8px; }
        .btn-red-modal { background-color: var(--btn-red); color: white; border-bottom: 8px solid var(--btn-red-shadow); border-radius: 24px; transition: all 0.1s; text-decoration: none; display: block; }
        .btn-red-modal:active { transform: translateY(8px); border-bottom: 0px; margin-bottom: 8px; }
    </style>
</head>
<body class="py-6 px-4 md:px-8">

    <!-- Butang Keluar ke Lobby di Penjuru Atas -->
    <a href="{{ route('peribahasa.lobby') }}" class="btn-exit-top" title="Keluar ke Menu Utama">
        ✖
    </a>

    <!-- Animasi Dekorasi Latar Belakang (Tapak Kaki Kucing Terapung) -->
    <div class="floating-paw left-[10%]" style="animation-duration: 15s; animation-delay: 0s;">🐾</div>
    <div class="floating-paw left-[30%]" style="animation-duration: 22s; animation-delay: 4s; font-size: 2.5rem;">🐾</div>
    <div class="floating-paw left-[60%]" style="animation-duration: 18s; animation-delay: 2s; font-size: 5rem;">🐾</div>
    <div class="floating-paw left-[85%]" style="animation-duration: 25s; animation-delay: 7s;">🐾</div>

    <div class="w-full max-w-4xl relative z-10 flex flex-col items-center pt-6">
        
        <!-- Header / Skor Comel -->
        <div class="bg-white/95 backdrop-blur-sm px-8 py-3 rounded-full shadow-[0_8px_0_rgba(0,0,0,0.05)] border-4 border-white inline-flex items-center justify-center gap-4 mb-10 mt-4 md:mt-0">
            <span class="text-2xl">🐱</span>
            <span class="text-[#D2427E] font-black text-xl uppercase tracking-widest">Markah:</span>
            <div class="font-game text-4xl text-[#F2629E] leading-none drop-shadow-sm" id="scoreText">0</div>
        </div>

        <!-- Arena Papan Comel -->
        <div class="cute-board flex flex-col p-8 md:p-12 min-h-[480px]">
            
            <!-- Bahagian Atas Papan (Soalan) -->
            <div id="questionArea" class="flex-1 flex flex-col items-center justify-center text-center relative">
                
                <!-- Lencana Nombor Soalan bertema Kayu -->
                <div id="questionCounter" class="bg-white text-[var(--wood-frame-shadow)] px-8 py-2 rounded-full font-game text-xl border-4 border-[var(--wood-frame)] shadow-sm absolute -top-16 flex items-center gap-2">
                    <span>Soalan 1 / 10</span>
                </div>

                <h2 class="font-handwriting text-4xl md:text-5xl text-var(--text-dark) font-bold leading-tight mt-6" id="questionText">
                    <!-- Teks soalan akan terus dipaparkan di sini tanpa tulisan loading -->
                </h2>
            </div>

            <!-- Bahagian Bawah (Pilihan Jawapan Butang 3D) -->
            <div id="answersArea" class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-10 w-full">
                <!-- Butang akan dijana oleh JS -->
            </div>

        </div>
    </div>

    <!-- Modal Status (Betul / Salah) -->
    <div id="feedbackModal" class="fixed inset-0 bg-[#3E2723]/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity opacity-0">
        <div class="bg-white p-8 rounded-[40px] text-center transform scale-90 transition-transform duration-300 max-w-md w-full border-8 border-white shadow-[0_15px_30px_rgba(0,0,0,0.2)]" id="feedbackContent">
            <div id="feedbackIcon" class="text-7xl mb-4">✅</div>
            <h2 id="feedbackTitle" class="font-game text-4xl mb-2 text-[#A9E868]" style="-webkit-text-stroke: 1px #82C83C;">Tepat Sekali!</h2>
            <p id="feedbackDesc" class="text-[var(--text-dark)] font-bold text-lg mb-8 bg-[#F8FDFE] p-4 rounded-2xl border-2 border-[var(--bg-color)]">Markah ditambah!</p>
            <button onclick="nextQuestion()" class="btn-blue-modal font-game w-full py-4 text-2xl">
                Seterusnya ➔
            </button>
        </div>
    </div>

    <!-- Modal Permainan Tamat -->
    <div id="gameOverModal" class="fixed inset-0 bg-[#3E2723]/80 backdrop-blur-md hidden items-center justify-center z-[60] transition-opacity opacity-0">
        <div class="bg-white p-10 rounded-[40px] text-center transform scale-90 transition-transform duration-300 max-w-lg w-full shadow-[0_15px_30px_rgba(0,0,0,0.3)] relative overflow-hidden" id="gameOverContent">
            
            <div class="text-7xl mb-2">🎉</div>
            <h2 class="font-game text-5xl mb-4 text-[#F2629E]">Tamat!</h2>
            
            <!-- 3 Bintang -->
            <div class="flex justify-center gap-2 mb-6" id="starContainer">
                <span class="star-icon" id="star1">★</span>
                <span class="star-icon" id="star2" style="transform: translateY(-15px);">★</span>
                <span class="star-icon" id="star3">★</span>
            </div>

            <div class="bg-[#FFF0F5] rounded-3xl p-6 mb-8 border-4 border-[#FFE4E1]">
                <p class="text-[#D2427E] font-black uppercase tracking-widest text-sm mb-1">Skor Markah Anda</p>
                <p class="font-game text-6xl text-[#FFD54F]" id="finalScore" style="-webkit-text-stroke: 2px #DCA92D;">0</p>
                <p class="text-lg font-bold mt-2 text-[var(--text-dark)]" id="scoreMessage">Hebat!</p>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <button onclick="location.reload()" class="btn-yellow-modal font-game w-full py-4 text-xl shadow-sm">
                    🔄 MAIN SEMULA
                </button>
                <a href="{{ route('peribahasa.lobby') }}" class="btn-red-modal font-game w-full py-4 text-xl shadow-sm">
                    ✖ KELUAR
                </a>
            </div>
        </div>
    </div>

    <script>
        let questions = [];
        let currentIndex = 0;
        let score = 0;

        // Kelas CSS untuk butang jawapan 3D Comel
        const cuteBtnClasses = [
            'chunky-btn btn-color-1', // Pink
            'chunky-btn btn-color-2', // Yellow
            'chunky-btn btn-color-3', // Blue
            'chunky-btn btn-color-4'  // Green
        ];

        // Bunyi Interaktif
        function playSound(type) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator(); const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                
                if (type === 'click') { 
                    osc.type = 'square'; osc.frequency.setValueAtTime(300, ctx.currentTime); 
                    osc.frequency.exponentialRampToValueAtTime(100, ctx.currentTime + 0.1); 
                    gain.gain.setValueAtTime(0.3, ctx.currentTime); gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1); 
                    osc.start(); osc.stop(ctx.currentTime + 0.1); 
                }
                else if (type === 'correct') { 
                    osc.type = 'sine'; osc.frequency.setValueAtTime(600, ctx.currentTime); 
                    osc.frequency.setValueAtTime(800, ctx.currentTime + 0.1); 
                    gain.gain.setValueAtTime(0.2, ctx.currentTime); gain.gain.linearRampToValueAtTime(0, ctx.currentTime + 0.3); 
                    osc.start(); osc.stop(ctx.currentTime + 0.3); 
                }
                else if (type === 'wrong') { 
                    osc.type = 'sawtooth'; osc.frequency.setValueAtTime(150, ctx.currentTime); 
                    gain.gain.setValueAtTime(0.2, ctx.currentTime); gain.gain.linearRampToValueAtTime(0, ctx.currentTime + 0.3); 
                    osc.start(); osc.stop(ctx.currentTime + 0.3); 
                }
            } catch(e) {}
        }

        // Dapatkan data daripada Controller
        window.onload = () => {
            fetch('/whiteboard/tahap-1')
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        questions = data.data;
                        loadQuestion();
                    }
                })
                .catch(err => alert("Gagal memuat turun soalan. Sila pastikan server berjalan."));
        };

        function loadQuestion() {
            if(currentIndex >= questions.length) {
                showGameOver();
                return;
            }

            const q = questions[currentIndex];
            const qArea = document.getElementById('questionArea');
            
            // Animasi masuk soalan baru
            qArea.classList.remove('wipe-animation');
            void qArea.offsetWidth; 
            qArea.classList.add('wipe-animation');

            document.getElementById('questionCounter').innerHTML = `<span>Soalan ${currentIndex + 1} / 10</span>`;
            document.getElementById('questionText').innerText = `"${q.maksud}"`;

            const ansArea = document.getElementById('answersArea');
            ansArea.innerHTML = ''; 

            // Pasang butang 3D
            q.pilihan.forEach((pil, index) => {
                const btn = document.createElement('button');
                btn.className = cuteBtnClasses[index % 4];
                btn.innerText = pil;
                btn.onclick = () => submitAnswer(pil, q.jawapan);
                ansArea.appendChild(btn);
            });
        }

        function submitAnswer(selected, correct) {
            playSound('click');
            const isCorrect = (selected === correct);
            
            const modal = document.getElementById('feedbackModal');
            const content = document.getElementById('feedbackContent');
            const icon = document.getElementById('feedbackIcon');
            const title = document.getElementById('feedbackTitle');
            const desc = document.getElementById('feedbackDesc');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-90');
                content.classList.add('scale-100');
            }, 10);

            if (isCorrect) {
                playSound('correct');
                score += 10;
                document.getElementById('scoreText').innerText = score;
                icon.innerText = '✅';
                title.innerText = 'Tepat Sekali!';
                title.style.color = '#A9E868';
                title.style.webkitTextStroke = '1px #82C83C';
                desc.innerText = 'Wah, anda memang pandai peribahasa!';
                confetti({ particleCount: 50, spread: 60, origin: {y: 0.4} });
            } else {
                playSound('wrong');
                icon.innerText = '❌';
                title.innerText = ' Jawapan salah!';
                title.style.color = '#F2629E';
                title.style.webkitTextStroke = '1px #D2427E';
                desc.innerHTML = `Jawapan yang betul ialah:<br><span class="text-[#F2629E] font-black text-xl mt-2 inline-block">${correct}</span>`;
            }
        }

        function nextQuestion() {
            const modal = document.getElementById('feedbackModal');
            const content = document.getElementById('feedbackContent');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-90');
            content.classList.remove('scale-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentIndex++;
                loadQuestion();
            }, 300);
        }

        function showGameOver() {
            const modal = document.getElementById('gameOverModal');
            const content = document.getElementById('gameOverContent');
            document.getElementById('finalScore').innerText = score;

            let msg = document.getElementById('scoreMessage');
            let starsEarned = 0;

            if (score === 100) { msg.innerText = "Meow-mazing! Anda sangat hebat!"; msg.style.color = '#82C83C'; starsEarned = 3; }
            else if (score >= 70) { msg.innerText = "Bagus! Usaha yang membanggakan!"; msg.style.color = '#3BA9C9'; starsEarned = 2; }
            else if (score >= 40) { msg.innerText = "Boleh tahan. Teruskan latihan!"; msg.style.color = '#DCA92D'; starsEarned = 1; }
            else { msg.innerText = "Jangan putus asa, cuba lagi!"; msg.style.color = '#D2427E'; starsEarned = 0; }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-90');
                content.classList.add('scale-100');
                
                // Animasi Bintang Satu per Satu
                setTimeout(() => { if(starsEarned >= 1) document.getElementById('star1').classList.add('star-earned'); }, 500);
                setTimeout(() => { if(starsEarned >= 2) document.getElementById('star2').classList.add('star-earned'); }, 1000);
                setTimeout(() => { 
                    if(starsEarned === 3) {
                        document.getElementById('star3').classList.add('star-earned'); 
                        confetti({ particleCount: 200, spread: 100, origin: {y: 0.6}, zIndex: 100 });
                    }
                }, 1500);

            }, 10);
        }
    </script>
</body>
</html>