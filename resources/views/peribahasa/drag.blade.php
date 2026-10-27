<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teka Peribahasa: Sifat Jahat Manusia 🍃🐸</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Comel Gemok & Ceria -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@700;900&display=swap" rel="stylesheet">
    <!-- Canvas Confetti untuk animasi kemenangan -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column; 
            align-items: center;
            justify-content: flex-start;
            overflow-x: hidden;
            position: relative;
            background: linear-gradient(to bottom, #7cd1eb 0%, #c4f0ff 65%);
        }

        .font-game { font-family: 'Fredoka One', cursive; letter-spacing: 1px; }

        /* Latar Belakang Vektor Hutan Beralun (Tanpa Kolam) */
        .bg-cartoon {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        /* Awan Comel Terapung */
        .cloud-1 { position: absolute; top: 6%; left: 8%; width: 130px; height: 45px; background: white; border-radius: 50px; opacity: 0.9; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .cloud-1::before { content:''; position: absolute; top: -18px; left: 20px; width: 50px; height: 50px; background: white; border-radius: 50%; }
        
        .cloud-2 { position: absolute; top: 10%; right: 12%; width: 160px; height: 50px; background: white; border-radius: 50px; opacity: 0.9; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .cloud-2::before { content:''; position: absolute; top: -22px; left: 30px; width: 60px; height: 60px; background: white; border-radius: 50%; }

        /* Lapisan Bukit Beralun Hijau */
        .hill-back {
            position: absolute; bottom: 0; left: 0; right: 0; height: 42%;
            background: #2dc653;
            border-top-left-radius: 100% 50px;
            border-top-right-radius: 100% 50px;
        }
        .hill-front {
            position: absolute; bottom: 0; left: 0; right: 0; height: 28%;
            background: #38b000;
            border-top-left-radius: 80% 60px;
            border-top-right-radius: 90% 60px;
        }

        /* Papan Utama Permainan (Besar & Luas) */
        .game-board {
            background: #ffffff;
            border: 8px solid #8b5a2b;
            border-radius: 40px;
            box-shadow: 0 15px 0 #5c3a21, 0 25px 40px rgba(0,0,0,0.25), inset 0 0 25px rgba(139,90,43,0.05);
            max-width: 680px;
            width: 100%;
            padding: 30px;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
            margin-top: 25px;
        }

        /* Banner Kayu Tajuk */
        .wood-banner {
            background: linear-gradient(to bottom, #d48331, #a0522d);
            border: 4px solid #5c3a21;
            border-radius: 20px;
            box-shadow: 0 6px 0 #3e2723, inset 0 2px 4px rgba(255,255,255,0.4);
            color: #fff;
            text-shadow: 2px 2px 0 #3e2723;
        }

        /* Kotak Huruf Grid Atas */
        .grid-tile {
            width: 48px; height: 48px; background: #fdf6e2; border: 3px solid #8b5a2b;
            border-radius: 14px; display: flex; align-items: center; justify-content: center;
            font-size: 26px; font-weight: 900; color: #5c3a21; box-shadow: 0 5px 0 #d7ccc8;
            text-transform: uppercase; user-select: none; cursor: pointer; transition: all 0.15s;
        }
        .grid-tile.filled { background: #8b5a2b; color: #fff9e6; border-color: #3e2723; box-shadow: 0 3px 0 #3e2723; transform: translateY(2px); }

        /* Jubin Huruf Pilihan Bawah */
        .draggable-tile {
            width: 52px; height: 52px; background: linear-gradient(to bottom, #ffffff, #f5e6d3);
            border: 3px solid #a0522d; border-radius: 16px; display: flex; align-items: center;
            justify-content: center; font-size: 24px; font-weight: 900; color: #8b5a2b;
            box-shadow: 0 6px 0 #8b5a2b; cursor: pointer; user-select: none; transition: transform 0.1s;
        }
        .draggable-tile:active { transform: translateY(4px); box-shadow: 0 1px 0 #8b5a2b; }

        /* Butang Hijau Gemok */
        .btn-green-chunky {
            background: linear-gradient(to bottom, #9acd32, #556b2f);
            border: 4px solid #38761d; border-radius: 20px; color: white;
            font-family: 'Fredoka One', cursive; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            box-shadow: 0 6px 0 #274e13, 0 10px 15px rgba(0,0,0,0.3); cursor: pointer; transition: all 0.1s;
        }
        .btn-green-chunky:active { transform: translateY(6px); box-shadow: 0 0 0 #274e13; }

        /* Butang Keluar (Pangkah di Kiri Atas Hujung) */
        .btn-keluar {
            width: 50px; height: 50px; background: linear-gradient(to bottom, #ff4d4d, #cc0000);
            border: 4px solid #800000; border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: white; font-size: 1.5rem; font-weight: 900;
            box-shadow: 0 6px 0 #4d0000; text-decoration: none; cursor: pointer; transition: all 0.1s;
        }
        .btn-keluar:active { transform: translateY(5px); box-shadow: 0 0 0 #4d0000; }

        /* Modal Pop-up */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7);
            display: flex; align-items: center; justify-content: center; z-index: 100; display: none;
        }
        .modal-box {
            background: #fff9e6; border: 8px solid #8b5a2b; border-radius: 35px; padding: 30px;
            text-align: center; max-width: 400px; width: 90%; box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="p-4">

    <!-- LATAR BELAKANG VEKTOR HUTAN -->
    <div class="bg-cartoon">
        <div class="cloud-1"></div>
        <div class="cloud-2"></div>
        <div class="hill-back"></div>
        <div class="hill-front"></div>
    </div>

    <!-- BEKAS KAWALAN UI UTAMA -->
    <div class="w-full max-w-[720px] flex flex-col items-center justify-center relative z-10">
        
        <!-- HEADER ATAS: PANGKAH KIRI, TAJUK TENGAH, MARKAH KANAN -->
        <div class="w-full flex justify-between items-center mb-4 px-1 relative" style="height: 65px;">
            
            <!-- 1. Butang Pangkah (Hujung Kiri Atas) -->
            <a href="{{ route('game.lobby') ?? '#' }}" class="btn-keluar z-25 flex-shrink-0">✖</a>
            
            <!-- 2. Tajuk Game (Tengah Atas) -->
            <div class="wood-banner px-8 py-2.5 text-center font-game text-xl md:text-2xl tracking-wide z-20 shadow-lg">
                🌿Cabaran minda 🍃
            </div>

            <!-- 3. Markah Keseluruhan (Kanan Atas) -->
            <div class="bg-white px-5 py-2.5 rounded-2xl border-4 border-[#8b5a2b] font-game text-xl text-[#8b5a2b] shadow-[0_5px_0_#8b5a2b] flex items-center gap-2 z-25 flex-shrink-0">
                ⭐ <span id="totalScore">0</span> / 100
            </div>

        </div>

        <!-- PAPAN GAME UTAMA -->
        <div class="game-board" id="gameContainer">
            
            <!-- Status Soalan (Format Soalan 1/10) -->
            <div class="flex justify-between items-center mb-4">
                <span id="roundIndicator" class="font-game text-sm text-[#8b5a2b] bg-[#f5e6d3] px-4 py-1.5 rounded-full border-2 border-[#a0522d]">Soalan 1 / 10</span>
                
            </div>

            <!-- Kad Pembayang / Maksud Peribahasa -->
            <div class="bg-[#f4f9f4] border-4 border-[#55b4d6] p-5 rounded-3xl mb-6 text-center shadow-inner">
                <p class="text-xs md:text-sm text-[#2980b9] font-black uppercase tracking-wider mb-1">Maksud / Pengajaran:</p>
                <p id="maksudTeks" class="text-base md:text-lg font-bold text-[#2d3748] mb-4 leading-relaxed"></p>
                
                <div class="bg-[#ffffff] p-3.5 rounded-2xl border-2 border-[#8b5a2b] inline-block w-full shadow-sm">
                    <span class="text-xs text-[#8b5a2b] font-black block mb-1">LENGKAPKAN PERIBAHASA:</span>
                    <span id="fullPeribahasaTeks" class="font-game text-xl md:text-2xl text-[#5c3a21] tracking-wide"></span>
                </div>
            </div>

            <!-- Papan Grid Huruf (Tempat Jawab) -->
            <div class="flex justify-center gap-2.5 mb-6 flex-wrap" id="gridContainer"></div>

            <!-- Ruang Huruf Pilihan di Bawah -->
            <div class="bg-[#eaf4ec] border-4 border-[#81c784] p-5 rounded-3xl flex flex-col items-center shadow-inner">
                <p class="text-xs text-[#2e7d32] mb-3 font-black tracking-wider">KLIK HURUF UNTUK MENYUSUN KATA:</p>
                <div class="flex justify-center gap-3 flex-wrap" id="rackContainer"></div>
            </div>

            <!-- Butang Susun Semula & Semak Jawapan -->
            <div class="mt-6 flex justify-between items-center">
                <button onclick="resetCurrentRound()" class="text-xs font-black text-[#8b5a2b] bg-[#f5e6d3] px-5 py-3 rounded-xl border-2 border-[#a0522d] shadow-[0_4px_0_#a0522d] active:translate-y-1">🔄 Susun Semula</button>
                <button id="actionBtn" onclick="handleAction()" class="btn-green-chunky hidden px-8 py-3 text-lg tracking-wider">Semak Jawapan ✨</button>
            </div>
        </div>
    </div>

    <!-- Modal Pop-up Keputusan (Betul / Salah) -->
    <div id="resultModal" class="modal-overlay">
        <div class="modal-box">
            <h3 id="modalTitle" class="font-game text-4xl mb-3"></h3>
            <p id="modalDesc" class="text-base font-bold text-[#3e2723] mb-5"></p>
            <div id="modalAnswerBox" class="mb-6"></div>
            <button onclick="closeModalAndNext()" class="btn-green-chunky w-full py-4 text-xl tracking-wider">Seterusnya ➔</button>
        </div>
    </div>

    <script>
        const roundsData = @json($rounds);

        let currentRoundIdx = 0;
        let totalScore = 0;
        let userSlots = []; 

        const gridContainer = document.getElementById('gridContainer');
        const rackContainer = document.getElementById('rackContainer');
        const maksudTeks = document.getElementById('maksudTeks');
        const fullPeribahasaTeks = document.getElementById('fullPeribahasaTeks');
        const roundIndicator = document.getElementById('roundIndicator');
        const totalScoreElem = document.getElementById('totalScore');
        const actionBtn = document.getElementById('actionBtn');
        
        const resultModal = document.getElementById('resultModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalAnswerBox = document.getElementById('modalAnswerBox');

        // Bunyi Confetti (Betul)
        function playSuccessSound() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(1046.50, audioCtx.currentTime + 0.2);
                gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 0.35);
                osc.connect(gain); gain.connect(audioCtx.destination);
                osc.start(); osc.stop(audioCtx.currentTime + 0.35);
            } catch(e) {}
        }

        // Bunyi Salah
        function playWrongSound() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(200, audioCtx.currentTime);
                osc.frequency.linearRampToValueAtTime(120, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 0.3);
                osc.connect(gain); gain.connect(audioCtx.destination);
                osc.start(); osc.stop(audioCtx.currentTime + 0.3);
            } catch(e) {}
        }

        function initRound() {
            actionBtn.classList.add('hidden');
            
            const data = roundsData[currentRoundIdx];
            roundIndicator.textContent = `Soalan ${data.round} / ${roundsData.length}`;
            maksudTeks.textContent = data.maksud;
            fullPeribahasaTeks.textContent = data.fullText;

            const targetWord = data.jawapan;
            userSlots = new Array(targetWord.length).fill(null);

            gridContainer.innerHTML = "";
            targetWord.split('').forEach((_, idx) => {
                const tile = document.createElement('div');
                tile.className = 'grid-tile';
                tile.dataset.index = idx;
                tile.onclick = () => {
                    if (userSlots[idx]) {
                        returnTileToRack(idx);
                    }
                };
                gridContainer.appendChild(tile);
            });

            rackContainer.innerHTML = "";
            let shuffledLetters = targetWord.split('').sort(() => Math.random() - 0.5);
            
            shuffledLetters.forEach((char, idx) => {
                const tile = document.createElement('div');
                tile.className = 'draggable-tile';
                tile.textContent = char;
                tile.dataset.rackId = idx;
                tile.onclick = () => placeTileToGrid(char, idx, tile);
                rackContainer.appendChild(tile);
            });
        }

        function placeTileToGrid(char, rackId, tileElement) {
            const emptyIdx = userSlots.indexOf(null);
            if (emptyIdx !== -1) {
                userSlots[emptyIdx] = { char, rackId };
                tileElement.style.display = 'none'; 
                renderGrid();
                checkIfComplete();
            }
        }

        function returnTileToRack(gridIdx) {
            const item = userSlots[gridIdx];
            if (!item) return;

            const rackTile = rackContainer.querySelector(`[data-rack-id='${item.rackId}']`);
            if (rackTile) rackTile.style.display = 'flex';

            userSlots[gridIdx] = null;
            renderGrid();
            actionBtn.classList.add('hidden');
        }

        function renderGrid() {
            const tiles = gridContainer.children;
            for (let i = 0; i < tiles.length; i++) {
                if (userSlots[i]) {
                    tiles[i].textContent = userSlots[i].char;
                    tiles[i].classList.add('filled');
                } else {
                    tiles[i].textContent = "";
                    tiles[i].classList.remove('filled');
                }
            }
        }

        function checkIfComplete() {
            if (!userSlots.includes(null)) actionBtn.classList.remove('hidden');
        }

        function resetCurrentRound() { initRound(); }

        function handleAction() {
            const currentData = roundsData[currentRoundIdx];
            const formedWord = userSlots.map(s => s.char).join('');

            fullPeribahasaTeks.textContent = currentData.fullText.replace(/\[\s*\]/g, currentData.jawapan);

            if (formedWord === currentData.jawapan) {
                totalScore += 10;
                if(totalScore > 100) totalScore = 100;
                totalScoreElem.textContent = totalScore;

                playSuccessSound();
                confetti({ particleCount: 120, spread: 90, origin: { y: 0.5 } });

                modalTitle.textContent = "HEBAT! 🎉";
                modalTitle.style.color = "#556b2f";
                modalDesc.textContent = "Tepat sekali! Anda mendapat +10 Markah.";
                modalAnswerBox.innerHTML = "";
            } else {
                totalScore -= 10;
                if(totalScore < 0) totalScore = 0;
                totalScoreElem.textContent = totalScore;

                playWrongSound();

                modalTitle.textContent = "SALAH!";
                modalTitle.style.color = "#cc0000";
                modalDesc.textContent = "Markah dipotong 10. Jawapan yang betul ialah:";
                modalAnswerBox.innerHTML = `<span class="font-game text-2xl text-[#8b5a2b] bg-[#fdf6e2] px-6 py-3 rounded-2xl border-4 border-[#a0522d] inline-block shadow-md tracking-wider">${currentData.jawapan}</span>`;
            }

            resultModal.style.display = 'flex';
        }

        function closeModalAndNext() {
            resultModal.style.display = 'none';
            currentRoundIdx++;

            if (currentRoundIdx < roundsData.length) {
                initRound();
            } else {
                document.getElementById('gameContainer').innerHTML = `
                    <div class="text-center py-10">
                        <h2 class="font-game text-5xl text-[#8b5a2b] mb-3">TAHNIAH! 🏆</h2>
                        <p class="text-base font-bold text-[#5c3a21] mb-8">Permainan tamat! Berikut adalah markah anda.</p>
                        <div class="bg-[#fdf6e2] border-4 border-[#8b5a2b] p-8 rounded-[40px] inline-block mb-10 shadow-lg">
                            <p class="text-sm text-[#a0522d] font-black mb-2">MARKAH KESELURUHAN</p>
                            <span class="font-game text-7xl text-[#3e2723]">${totalScore} / 100</span>
                        </div>
                        <div>
                            <button onclick="location.reload()" class="btn-green-chunky px-10 py-4 text-2xl w-full max-w-[300px]">Main Semula 🔄</button>
                        </div>
                    </div>
                `;
            }
        }

        initRound();
    </script>
</body>
</html>