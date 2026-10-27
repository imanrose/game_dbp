<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teka Situasi Kampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700;900&family=Fredoka+One&display=swap');
        
        body {
            font-family: 'Nunito', sans-serif;
            /* Latar belakang tema dinding kayu papan desa yang kemas */
            background-color: #3b2211;
            background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            margin: 0;
            padding: 20px;
        }

        .font-game { font-family: 'Fredoka One', cursive; }

        /* Papan Utama Kayu Luar */
        .board-main {
            background-color: #F5DEB3;
            background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
            border: 14px solid #6D4C41;
            border-radius: 35px;
            box-shadow: 
                inset 0 0 30px rgba(109, 76, 65, 0.4), 
                0 20px 40px rgba(0,0,0,0.6),
                0 0 0 6px #4E342E;
            position: relative;
        }

        /* Kotak Situasi: Corak Kayu Klasik Berukir Panel Baru */
        .wood-situation-panel {
            background-color: #4a2e18;
            background-image: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, rgba(0,0,0,0.3) 100%), url('https://www.transparenttextures.com/patterns/wood-pattern.png');
            border: 8px solid #271612;
            border-radius: 24px;
            box-shadow: inset 0 0 25px rgba(0,0,0,0.7), 0 10px 20px rgba(0,0,0,0.4);
            position: relative;
            color: #fff8e7;
        }

        /* Butang Keluar Bulat Pangkah di Kiri */
        .btn-close-round {
            width: 55px;
            height: 55px;
            background: linear-gradient(to bottom, #ff5252, #d32f2f);
            border: 4px solid #b71c1c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 900;
            box-shadow: 0 6px 0 #8e0000, 0 10px 15px rgba(0,0,0,0.4);
            transition: all 0.1s ease;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-close-round:active {
            transform: translateY(6px);
            box-shadow: 0 0 0 #8e0000, 0 4px 6px rgba(0,0,0,0.4);
        }

        /* Markah Bulat Kayu */
        .coconut-box {
            background: radial-gradient(circle at 30% 30%, #795548, #3E2723);
            border: 4px solid #271612;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: inset -5px -5px 15px rgba(0,0,0,0.5), 0 10px 15px rgba(0,0,0,0.4);
            position: relative;
            z-index: 20;
        }
        
        .coconut-box::before {
            content: ''; position: absolute; top: 10px; right: 15px; width: 25px; height: 12px;
            background: rgba(255,255,255,0.15); border-radius: 50%; transform: rotate(-30deg);
        }

        /* Palang Buluh */
        .bamboo-bar {
            background: linear-gradient(to bottom, #E6C27A, #B48C46);
            border: 3px solid #6E4D21;
            border-radius: 20px;
            height: 25px;
            box-shadow: inset 0 3px 5px rgba(255,255,255,0.4), 0 5px 10px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .bamboo-fill {
            background: linear-gradient(to bottom, #8BC34A, #33691E);
            height: 100%;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 3px solid #1B5E20;
        }

        /* Butang Pilihan Jawapan Tekstur Kayu 3D */
        .wood-btn {
            background-color: #8b5a2b;
            background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png'), linear-gradient(to bottom, #a16e4b, #5c3a21);
            border: 4px solid #3e2723;
            border-radius: 25px;
            color: #FFF3E0;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
            box-shadow: 0 8px 0 #271612, 0 15px 20px rgba(0,0,0,0.4), inset 0 2px 5px rgba(255,255,255,0.2);
            transition: all 0.15s ease;
            position: relative;
            cursor: pointer;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 900;
        }

        .wood-btn:active:not(:disabled) {
            transform: translateY(8px);
            box-shadow: 0 0 0 #271612, 0 5px 10px rgba(0,0,0,0.4);
        }

        .wood-btn:hover:not(:disabled) {
            filter: brightness(1.1);
        }

        .label-huruf {
            background: #271612;
            color: #FFD54F;
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 1.2rem;
            font-weight: 900;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);
        }

        /* State Betul / Salah */
        .wood-btn.correct {
            background: linear-gradient(to bottom, #66BB6A, #2E7D32) !important;
            border-color: #1B5E20 !important;
            box-shadow: 0 8px 0 #1B5E20, 0 15px 20px rgba(0,0,0,0.4) !important;
        }
        .wood-btn.wrong {
            background: linear-gradient(to bottom, #EF5350, #C62828) !important;
            border-color: #B71C1C !important;
            box-shadow: 0 8px 0 #B71C1C, 0 15px 20px rgba(0,0,0,0.4) !important;
            opacity: 0.85;
        }

        /* Butang Next / Main Semula */
        .btn-next {
            background: linear-gradient(to bottom, #FFB300, #F57C00);
            border: 4px solid #E65100;
            border-radius: 20px;
            color: white;
            text-shadow: 1px 1px 2px #E65100;
            box-shadow: 0 6px 0 #BF360C, 0 10px 15px rgba(0,0,0,0.3);
            transition: all 0.1s;
        }
        .btn-next:active { transform: translateY(6px); box-shadow: 0 0 0 #BF360C; }

        /* Animasi Markah Timbul */
        .float-score {
            position: absolute;
            font-size: 2.5rem;
            font-weight: 900;
            opacity: 0;
            pointer-events: none;
            z-index: 50;
            animation: floatUp 1.5s forwards;
            text-shadow: 2px 2px 0 #000, -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000;
        }
        .plus { color: #4ADE80; }
        .minus { color: #F87171; }

        @keyframes floatUp {
            0% { transform: translateY(0) scale(0.5); opacity: 1; }
            50% { transform: translateY(-50px) scale(1.2); opacity: 1; }
            100% { transform: translateY(-100px) scale(1); opacity: 0; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl relative">
        
        <!-- Header / Butang Keluar Pangkah di Sebelah Kiri -->
        <div class="absolute -top-16 left-0 right-0 flex justify-between items-center z-10 px-4">
            <!-- Butang Keluar Pangkah Bulat di Kiri -->
            <a href="{{ route('game.lobby') ?? '#' }}" class="btn-close-round" title="Keluar Lobi">
                ✖
            </a>
            
            
            <div style="width: 55px;"></div> <!-- Penyeimbang ruang kanan -->
        </div>

        <div class="board-main w-full p-6 md:p-10 mt-10">
            
            <!-- Bahagian Atas: Markah & Buluh -->
            <div class="flex items-center gap-6 mb-10 pl-2">
                <!-- Markah Kelapa -->
                <div class="coconut-box font-game">
                    <span id="scoreDisplay" class="text-2xl mt-1">0</span>
                    <span class="text-yellow-400 text-sm">⭐</span>
                </div>
                
                <!-- Progress Buluh -->
                <div class="flex-grow max-w-lg mt-4 relative">
                    <div class="absolute -top-7 left-2 text-[#5D4037] font-black text-lg font-game tracking-wider">
                        Soalan <span id="currentQ">1</span> / 10
                    </div>
                    <div class="bamboo-bar">
                        <div id="progressBar" class="bamboo-fill" style="width: 10%;"></div>
                    </div>
                </div>
            </div>

            <!-- Kawasan Kandungan (Kiri & Kanan) -->
            <div class="flex flex-col md:flex-row gap-10">
                
                <!-- Panel Kiri: Situasi Kayu Klasik Baru -->
                <div class="w-full md:w-5/12 relative flex flex-col">
                    <div class="wood-situation-panel p-8 h-full flex flex-col justify-center shadow-2xl">
                        
                        <!-- Ikon Tanda Tanya -->
                        <div class="absolute top-4 right-4 bg-[#271612] text-[#ffecb3] rounded-full w-10 h-10 flex items-center justify-center font-bold text-xl border-2 border-[#5c3a21] shadow-md">
                            ?
                        </div>

                        <h3 class="font-game text-2xl text-[#ffecb3] mb-3 border-b-4 border-[#271612] pb-2 inline-block">Situasi:</h3>
                        <p id="situationText" class="text-xl text-[#fff8e7] font-bold leading-relaxed">
                            <!-- Teks disuntik oleh JS -->
                        </p>
                    </div>
                </div>

                <!-- Panel Kanan: Pilihan Jawapan (Susunan Asal 1-10) -->
                <div class="w-full md:w-7/12 flex flex-col justify-center gap-5" id="optionsContainer" style="position: relative;">
                    <!-- Butang dijana oleh JS -->
                </div>
            </div>

            <!-- Bahagian Bawah: Butang Seterusnya / Main Semula -->
            <div class="mt-8 flex justify-end h-14">
                <button id="nextBtn" class="hidden btn-next font-game text-xl py-2 px-8 flex items-center justify-center">
                    Seterusnya ➔
                </button>
            </div>

        </div>
    </div>

    <script>
        // Data soalan dikekalkan urutan asal 1 hingga 10 tanpa di-shuffle
        const db = @json($soalan);
        
        let currentIndex = 0;
        let score = 0;
        const totalQ = db.length;

        const ui = {
            situation: document.getElementById('situationText'),
            options: document.getElementById('optionsContainer'),
            currQ: document.getElementById('currentQ'),
            progress: document.getElementById('progressBar'),
            score: document.getElementById('scoreDisplay'),
            nextBtn: document.getElementById('nextBtn')
        };

        function loadLevel() {
            ui.nextBtn.classList.add('hidden');
            const data = db[currentIndex];
            
            ui.situation.textContent = data.situasi;
            ui.currQ.textContent = currentIndex + 1;
            ui.progress.style.width = `${((currentIndex + 1) / totalQ) * 100}%`;
            
            ui.options.innerHTML = '';
            
            const labels = ['A', 'B', 'C', 'D'];
            // Pilihan jawapan kekal mengikut susunan asal dalam tatasusunan soalan
            data.pilihan.forEach((pilihan, idx) => {
                const btn = document.createElement('button');
                btn.className = 'wood-btn text-base md:text-lg font-bold text-left w-full';
                btn.innerHTML = `<span class="label-huruf">${labels[idx]}</span> <span class="flex-grow">${pilihan}</span>`;
                
                btn.onclick = (e) => checkAnswer(btn, pilihan, data.jawapan, e);
                ui.options.appendChild(btn);
            });
        }

        function checkAnswer(btn, userAns, correctAns, event) {
            const allBtns = ui.options.querySelectorAll('button');
            allBtns.forEach(b => b.disabled = true); // Kunci semua butang

            // Elemen animasi markah
            const floatingText = document.createElement('div');
            floatingText.className = 'float-score';
            
            const rect = btn.getBoundingClientRect();
            floatingText.style.left = (event.clientX - rect.left + 20) + 'px';
            floatingText.style.top = '10px';

            if (userAns === correctAns) {
                // LOGIK BETUL (+10)
                btn.classList.add('correct');
                score += 10;
                if(score > 100) score = 100; // Maksimum 100
                
                floatingText.textContent = "+10";
                floatingText.classList.add('plus');
            } else {
                // LOGIK SALAH (-10)
                btn.classList.add('wrong');
                score -= 10;
                if(score < 0) score = 0; // Minimum 0
                
                floatingText.textContent = "-10";
                floatingText.classList.add('minus');

                // Tunjuk jawapan yang betul kepada pemain
                allBtns.forEach(b => {
                    if(b.textContent.includes(correctAns)) {
                        b.classList.add('correct');
                    }
                });
            }

            btn.appendChild(floatingText);
            ui.score.textContent = score;
            
            setTimeout(() => floatingText.remove(), 1500);
            ui.nextBtn.classList.remove('hidden');
        }

        ui.nextBtn.addEventListener('click', () => {
            currentIndex++;
            if (currentIndex < totalQ) {
                loadLevel();
            } else {
                // Skrin Tamat Permainan + Butang Main Semula
                ui.options.innerHTML = `
                    <div class="wood-situation-panel p-8 text-center shadow-2xl">
                        <h2 class="font-game text-4xl text-[#ffecb3] mb-4">TAMAT!</h2>
                        <p class="text-2xl font-bold text-[#fff8e7]">Markah Akhir Anda:</p>
                        <div class="text-6xl font-black text-[#ffd166] my-4 drop-shadow-md font-game">${score} / 100</div>
                        <p class="text-lg font-bold text-[#d7ccc8] mb-6">Tahniah atas usaha anda menyelesaikan teka situasi warisan Melayu.</p>
                        <button onclick="mulaSemula()" class="btn-next font-game text-xl py-3 px-8 inline-flex items-center justify-center gap-2 cursor-pointer">
                            🔄 Main Semula
                        </button>
                    </div>`;
                ui.situation.textContent = "Terima kasih kerana bermain teka situasi warisan Melayu.";
                ui.nextBtn.classList.add('hidden');
            }
        });

        // Fungsi untuk reset dan mula main semula
        function mulaSemula() {
            currentIndex = 0;
            score = 0;
            ui.score.textContent = score;
            loadLevel();
        }

        // Mulakan permainan
        loadLevel();
    </script>
</body>
</html>