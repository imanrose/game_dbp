<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teka Silang Kata - Tema Taman Ceria</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&family=Poppins:wght@500;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            /* Tema Flat Design Ceria */
            --sky-blue: #61D8F9;
            --grass-green: #A9E868;
            --btn-pink: #F2629E;
            --btn-pink-shadow: #D2427E;
            --btn-yellow: #FFD54F;
            --btn-yellow-shadow: #DCA92D;
            --text-dark: #2D4059;
            
            /* Warna Papan Silang Kata Pastel */
            --board-pastel: #B3E5FC; 
            --board-pastel-border: #81D4FA;
            --cell-bg: #FFFFFF;
            --cell-highlight: #FFF0F5; 
            --word-highlight: #FFE4E1; 
        }

        body { 
            background-color: var(--sky-blue); 
            background-image: linear-gradient(180deg, #61D8F9 0%, #85E0FA 45%, #A9E868 45%, #90D646 100%);
            background-attachment: fixed;
            color: var(--text-dark); 
            font-family: 'Nunito', sans-serif; 
            min-height: 100vh; 
            overflow-x: hidden;
        }

        .font-game { font-family: 'Fredoka One', cursive; letter-spacing: 1px; }
        .font-heading { font-family: 'Poppins', sans-serif; }

        /* Animasi Latar Belakang */
        .cloud { position: fixed; z-index: 0; opacity: 0.85; animation: drift linear infinite; pointer-events: none; }
        .bird { position: fixed; z-index: 0; animation: fly linear infinite; pointer-events: none; }
        .star { position: fixed; z-index: 0; animation: twinkle infinite alternate; filter: drop-shadow(0 4px 4px rgba(0,0,0,0.1)); pointer-events: none; }
        
        @keyframes drift { 0% { transform: translateX(-30vw); } 100% { transform: translateX(120vw); } }
        @keyframes fly { 0% { transform: translate(-10vw, 10vh); } 50% { transform: translate(50vw, 5vh) translateY(-30px); } 100% { transform: translate(120vw, 15vh); } }
        @keyframes spin-slow { 100% { transform: rotate(360deg); } }
        @keyframes twinkle { 0% { transform: scale(0.8) rotate(-10deg); opacity: 0.6; } 100% { transform: scale(1.1) rotate(10deg); opacity: 1; } }

        /* Papan Silang Kata Wrapper */
        #crossword-wrapper { 
            background: var(--board-pastel); 
            padding: 24px; 
            border-radius: 40px; 
            box-shadow: inset 0 0 0 6px var(--board-pastel-border), 0 15px 30px rgba(0, 0, 0, 0.15); 
            border: 8px solid white; 
            margin: 0 auto; 
            width: fit-content; 
        }

        #crossword-board { 
            display: grid; gap: 4px; 
            background-color: transparent; 
            border: none; 
        }

        .grid-cell { width: 40px; height: 40px; background-color: transparent; position: relative; }
        
        /* Gaya Kotak Silang Kata 3D */
        .grid-cell.active { 
            background-color: var(--cell-bg); 
            border: 3px solid #EAF6F9;
            border-radius: 10px;
            box-shadow: 0 4px 0 #DDF1F6;
            transition: all 0.2s ease; 
        }
        
        .grid-cell.highlight-word { background-color: #FFF0F5; border-color: #FFB6C1; box-shadow: 0 4px 0 #FF9EAE; }
        .grid-cell.highlight-cell { background-color: #FFFFFF; transform: scale(1.15); z-index: 10; border-color: #F2629E; box-shadow: 0 6px 0 #D2427E; }

        .cell-input { 
            width: 100%; height: 100%; border: none; background: transparent; text-align: center; 
            font-size: 1.25rem; font-weight: 900; font-family: 'Poppins', sans-serif; 
            text-transform: uppercase; outline: none; cursor: pointer; padding: 0; 
            color: var(--text-dark); transition: color 0.3s ease; 
        }
        
        .cell-input.correct { color: #2ed573; text-shadow: 1px 1px 0px rgba(0,0,0,0.1); } 
        .cell-input.revealed { color: #ff4757; animation: popText 0.3s ease-out; } 
        
        @keyframes popText { 0% { transform: scale(0.5); opacity: 0; } 50% { transform: scale(1.2); } 100% { transform: scale(1); opacity: 1; } }
        
        .cell-number { position: absolute; top: 2px; left: 4px; font-size: 0.65rem; font-weight: 800; pointer-events: none; color: var(--text-dark); opacity: 0.5; }
        
        /* Senarai Pembayang */
        .clue-list li { 
            margin-bottom: 12px; cursor: pointer; padding: 12px 16px; 
            border-radius: 20px; background-color: #ffffff; 
            border: 4px solid transparent; 
            box-shadow: 0 4px 0 #EAF6F9; 
            transition: all 0.2s; 
        }
        .clue-list li:hover { transform: translateY(-2px); box-shadow: 0 6px 0 #DDF1F6; }
        .clue-list li.active-clue { background-color: #FFF0F5; border-color: #FFB6C1; box-shadow: 0 4px 0 #FF9EAE; }

        /* Butang */
        .btn-pink { background-color: var(--btn-pink); color: white; border-bottom: 8px solid var(--btn-pink-shadow); transition: all 0.1s; }
        .btn-pink:active { transform: translateY(8px); border-bottom: 0px solid var(--btn-pink-shadow); margin-bottom: 8px; }
        .btn-yellow { background-color: var(--btn-yellow); color: var(--text-dark); border-bottom: 8px solid var(--btn-yellow-shadow); transition: all 0.1s; }
        .btn-yellow:active { transform: translateY(8px); border-bottom: 0px solid var(--btn-yellow-shadow); margin-bottom: 8px; }
    </style>
</head>
<body class="py-8 px-4 md:px-8">

    <!-- Animasi Dekorasi -->
    <div class="fixed top-4 right-10 text-[120px] z-0 drop-shadow-xl" style="animation: spin-slow 30s linear infinite;">☀️</div>
    <div class="cloud text-8xl top-10" style="animation-duration: 40s;">☁️</div>
    <div class="cloud text-9xl top-32" style="animation-duration: 25s; animation-delay: 5s;">☁️</div>
    <div class="bird text-6xl top-40" style="animation-duration: 18s;">🕊️</div>
    <div class="bird text-7xl top-20" style="animation-duration: 22s; animation-delay: 8s;">🦅</div>
    <div class="fixed bottom-0 left-4 text-[160px] z-0 drop-shadow-2xl">🏡🌳</div>
    
    <div class="star top-20 left-20 text-5xl" style="animation-duration: 2s;">⭐</div>
    <div class="star top-40 right-[25%] text-6xl" style="animation-duration: 3s; animation-delay: 0.5s;">🌟</div>
    <div class="star bottom-32 left-10 text-5xl" style="animation-duration: 2.5s; animation-delay: 1s;">✨</div>
    <div class="star top-10 left-1/3 text-4xl" style="animation-duration: 4s; animation-delay: 1.5s;">⭐</div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        <header class="text-center mb-6 w-full relative z-10 flex flex-col items-center justify-center mt-2">
            <span class="bg-[#F2629E] text-white text-sm font-black px-5 py-2 rounded-full uppercase tracking-widest mb-4 shadow-[0_4px_0_#D2427E] border-2 border-white">Dewan Bahasa dan Pustaka</span>
            <h1 class="font-game text-5xl md:text-6xl text-[#FFD54F] mb-3 uppercase tracking-widest" style="-webkit-text-stroke: 2px white; text-shadow: 0 4px 0 rgba(0,0,0,0.1);">
                Teka Silang Kata
            </h1>
            <p class="text-lg font-bold text-[#2D4059] bg-white/90 px-6 py-2 rounded-full shadow-sm backdrop-blur-sm border-2 border-white">Lengkapkan semua kotak untuk melihat markah penuh!</p>
        </header>

        <main class="grid grid-cols-1 xl:grid-cols-3 gap-8 mt-8">
            <div class="xl:col-span-2 flex flex-col items-center">
                <div id="active-clue-display" class="w-full max-w-2xl bg-white border-4 border-[#61D8F9] shadow-[0_8px_0_#3BA9C9] rounded-[24px] p-6 mb-8 transition-all duration-300 min-h-[100px] flex items-center justify-center text-center">
                    <p class="text-[#2D4059] font-bold text-xl italic">Pilih kotak putih untuk mula meneka.</p>
                </div>
                
                <div class="overflow-x-auto w-full pb-6 flex justify-center">
                    <div id="crossword-wrapper"><div id="crossword-board"></div></div>
                </div>
                
                <div class="w-full max-w-2xl mt-4 flex justify-center xl:justify-end">
                    <button id="btnCheck" class="btn-pink font-game px-8 py-4 rounded-full text-xl shadow-sm flex items-center gap-3">
                        <span>HANTAR & SEMAK JAWAPAN</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </button>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-md p-8 rounded-[40px] border-4 border-white shadow-[0_15px_30px_rgba(0,0,0,0.1)] h-fit flex flex-col gap-6 max-h-[800px] overflow-y-auto">
                <h2 class="font-game text-3xl text-[#F2629E] flex items-center gap-2 border-b-4 border-white/50 pb-4" style="-webkit-text-stroke: 1px white;">💡 Pembayang</h2>
                <div>
                    <h3 class="font-game text-lg text-white bg-[#61D8F9] border-b-4 border-[#3BA9C9] px-4 py-2 rounded-2xl mb-4 uppercase tracking-wider inline-block">Melintang</h3>
                    <ul id="clues-across" class="clue-list"></ul>
                </div>
                <div class="mt-2">
                    <h3 class="font-game text-lg text-[#2D4059] bg-[#FFD54F] border-b-4 border-[#DCA92D] px-4 py-2 rounded-2xl mb-4 uppercase tracking-wider inline-block">Menegak</h3>
                    <ul id="clues-down" class="clue-list"></ul>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Menang -->
    <div id="successMessage" class="fixed inset-0 bg-[#2D4059]/80 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-opacity duration-300 z-[60]">
        <div class="bg-white rounded-[40px] p-10 max-w-lg w-full text-center border-8 border-[#A9E868] shadow-[0_15px_0_rgba(0,0,0,0.2)] transform scale-95 transition-transform duration-300" id="successContent">
            <div class="text-8xl mb-4">🏆</div>
            <h2 class="font-game text-5xl text-[#F2629E] mb-2">Hebat!</h2>
            <p class="text-xl font-bold text-[#2D4059] mb-6">Semua teka silang kata telah disemak.</p>
            
            <div class="bg-[#F8FDFE] p-6 rounded-[30px] mb-8 border-4 border-[#FFE4E1]">
                <p class="text-xl font-black text-[#2D4059] uppercase tracking-widest mb-2">Markah Akhir Anda</p>
                <p class="text-6xl font-game text-[#FFD54F]" id="scoreDisplay" style="-webkit-text-stroke: 2px #DCA92D;">0 / 100</p>
            </div>

            <div class="flex flex-col gap-3">
                <button onclick="resetBoard()" class="w-full btn-yellow font-game px-6 py-4 rounded-full text-2xl shadow-sm">
                    🔄 MAIN SEMULA
                </button>
            </div>
        </div>
    </div>

    <script>
        // Tarik data daripada Controller
        let rawDB = @json($peribahasaData);

        // KUNCI UTAMA: Sort ikut ID untuk elak random.
        rawDB.sort((a, b) => a.id - b.id);
        const peribahasaDB = rawDB;

        // Saiz grid dibesarkan supaya confirm muat 10 soalan
        const BOARD_SIZE = 20; 
        let grid = []; let placedWords = []; let currentDirection = 'across'; let selectedCell = null; 
        let score = 0;

        function initGrid() { grid = Array.from({ length: BOARD_SIZE }, () => Array(BOARD_SIZE).fill(null)); }

        function canPlaceWord(word, startX, startY, isAcross) {
            let intersections = 0;
            if (isAcross) {
                if (startX + word.length > BOARD_SIZE) return false;
                for (let i = 0; i < word.length; i++) {
                    const x = startX + i; const y = startY; const cell = grid[y][x];
                    if (cell) { if (cell.char !== word[i]) return false; intersections++; } 
                    else { if (y > 0 && grid[y - 1][x]) return false; if (y < BOARD_SIZE - 1 && grid[y + 1][x]) return false; }
                }
                if (startX > 0 && grid[startY][startX - 1]) return false;
                if (startX + word.length < BOARD_SIZE && grid[startY][startX + word.length]) return false;
            } else { 
                if (startY + word.length > BOARD_SIZE) return false;
                for (let i = 0; i < word.length; i++) {
                    const x = startX; const y = startY + i; const cell = grid[y][x];
                    if (cell) { if (cell.char !== word[i]) return false; intersections++; } 
                    else { if (x > 0 && grid[y][x - 1]) return false; if (x < BOARD_SIZE - 1 && grid[y][x + 1]) return false; }
                }
                if (startY > 0 && grid[startY - 1][startX]) return false;
                if (startY + word.length < BOARD_SIZE && grid[startY + word.length][startX]) return false;
            }
            return { canPlace: true, intersections };
        }

        function placeWord(wordObj, startX, startY, isAcross, number) {
            const word = wordObj.jawapan;
            for (let i = 0; i < word.length; i++) {
                const x = isAcross ? startX + i : startX; const y = isAcross ? startY : startY + i;
                if (!grid[y][x]) grid[y][x] = { char: word[i], acrossWord: null, downWord: null };
                if (isAcross) grid[y][x].acrossWord = number; else grid[y][x].downWord = number;
                if (i === 0) grid[y][x].number = number;
            }
            placedWords.push({ ...wordObj, x: startX, y: startY, isAcross: isAcross, number: number });
        }

        // GENERATOR TETAP (DIJAMIN 10 SOALAN)
        function generateCrossword() {
            initGrid(); placedWords = []; let wordCounter = 1;
            
            // Tepat ambil 10 soalan
            let pool = [...peribahasaDB].slice(0, 10);
            if(pool.length === 0) return;

            // Letak perkataan pertama di tengah
            const firstWord = pool.shift();
            const startX = Math.floor((BOARD_SIZE - firstWord.jawapan.length) / 2);
            const startY = Math.floor(BOARD_SIZE / 2);
            placeWord(firstWord, startX, startY, true, wordCounter++);

            // Loop untuk letak baki 9 perkataan
            for (const wordObj of pool) {
                const word = wordObj.jawapan; 
                let bestPlacement = null;

                // 1. Cuba cari cantuman (intersection)
                for (let y = 0; y < BOARD_SIZE; y++) {
                    for (let x = 0; x < BOARD_SIZE; x++) {
                        const resAcross = canPlaceWord(word, x, y, true);
                        if (resAcross.canPlace && resAcross.intersections > 0) {
                            if (!bestPlacement || resAcross.intersections > bestPlacement.intersections) bestPlacement = { x, y, isAcross: true, intersections: resAcross.intersections };
                        }
                        const resDown = canPlaceWord(word, x, y, false);
                        if (resDown.canPlace && resDown.intersections > 0) {
                            if (!bestPlacement || resDown.intersections > bestPlacement.intersections) bestPlacement = { x, y, isAcross: false, intersections: resDown.intersections };
                        }
                    }
                }

                if (bestPlacement) {
                    // Kalau boleh cantum, letak sini
                    placeWord(wordObj, bestPlacement.x, bestPlacement.y, bestPlacement.isAcross, wordCounter++);
                } else {
                    // 2. JIKA TAK BOLEH CANTUM (Fallback: Paksa letak supaya 10 soalan lengkap)
                    let placed = false;
                    for (let y = 0; y < BOARD_SIZE && !placed; y+=2) {
                        for (let x = 0; x < BOARD_SIZE && !placed; x+=2) {
                            if (canPlaceWord(word, x, y, true).canPlace) {
                                placeWord(wordObj, x, y, true, wordCounter++);
                                placed = true;
                            } else if (canPlaceWord(word, x, y, false).canPlace) {
                                placeWord(wordObj, x, y, false, wordCounter++);
                                placed = true;
                            }
                        }
                    }
                }
            }
        }

        function playClickSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator(); const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.type = 'sine'; osc.frequency.setValueAtTime(600, ctx.currentTime); osc.frequency.exponentialRampToValueAtTime(100, ctx.currentTime + 0.05);
                gain.gain.setValueAtTime(0.1, ctx.currentTime); gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.05);
                osc.start(ctx.currentTime); osc.stop(ctx.currentTime + 0.05);
            } catch(e) {}
        }

        function renderGrid() {
            const boardEl = document.getElementById('crossword-board');
            boardEl.innerHTML = ''; boardEl.style.gridTemplateColumns = `repeat(${BOARD_SIZE}, 1fr)`;
            for (let y = 0; y < BOARD_SIZE; y++) {
                for (let x = 0; x < BOARD_SIZE; x++) {
                    const cellData = grid[y][x]; const cellEl = document.createElement('div');
                    cellEl.className = 'grid-cell flex items-center justify-center';
                    if (cellData) {
                        cellEl.classList.add('active'); cellEl.dataset.x = x; cellEl.dataset.y = y;
                        if (cellData.acrossWord) cellEl.dataset.across = cellData.acrossWord;
                        if (cellData.downWord) cellEl.dataset.down = cellData.downWord;
                        if (cellData.number) { const numEl = document.createElement('div'); numEl.className = 'cell-number'; numEl.innerText = cellData.number; cellEl.appendChild(numEl); }
                        
                        const inputEl = document.createElement('input'); inputEl.type = 'text'; inputEl.maxLength = 1; inputEl.className = 'cell-input'; inputEl.dataset.correctChar = cellData.char;
                        
                        inputEl.addEventListener('focus', () => {
                            playClickSound();
                            handleCellFocus(x, y, cellData);
                        });
                        inputEl.addEventListener('input', (e) => handleCellInput(e, x, y));
                        inputEl.addEventListener('keydown', (e) => handleCellKeydown(e, x, y));
                        cellEl.appendChild(inputEl);
                    }
                    boardEl.appendChild(cellEl);
                }
            }
        }

        function renderClues() {
            const acrossList = document.getElementById('clues-across'); const downList = document.getElementById('clues-down');
            acrossList.innerHTML = ''; downList.innerHTML = '';
            placedWords.sort((a, b) => a.number - b.number);
            placedWords.forEach(word => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <div class="flex gap-3">
                        <span class="font-game text-[#F2629E] text-2xl mt-1">${word.number}.</span> 
                        <div>
                            <span class="font-bold text-[#2D4059] text-lg">${word.peribahasa}</span>
                            <div class="text-sm font-semibold text-[#2D4059]/70 mt-1">${word.maksud}</div>
                        </div>
                    </div>`;
                li.dataset.number = word.number; li.dataset.direction = word.isAcross ? 'across' : 'down';
                li.addEventListener('click', () => highlightWord(word.number, word.isAcross ? 'across' : 'down'));
                if (word.isAcross) acrossList.appendChild(li); else downList.appendChild(li);
            });
        }

        function handleCellFocus(x, y, cellData) {
            selectedCell = { x, y };
            if (cellData.acrossWord && cellData.downWord) currentDirection = currentDirection === 'across' ? 'down' : 'across';
            else if (cellData.acrossWord) currentDirection = 'across'; else if (cellData.downWord) currentDirection = 'down';
            highlightWord(currentDirection === 'across' ? cellData.acrossWord : cellData.downWord, currentDirection);
        }

        function highlightWord(wordNumber, direction) {
            document.querySelectorAll('.grid-cell').forEach(c => c.classList.remove('highlight-word', 'highlight-cell'));
            document.querySelectorAll('.clue-list li').forEach(l => l.classList.remove('active-clue'));
            if (!wordNumber) return;
            const attr = direction === 'across' ? 'data-across' : 'data-down';
            document.querySelectorAll(`.grid-cell[${attr}="${wordNumber}"]`).forEach(c => c.classList.add('highlight-word'));
            if (selectedCell) { const activeEl = document.querySelector(`.grid-cell[data-x="${selectedCell.x}"][data-y="${selectedCell.y}"]`); if (activeEl) activeEl.classList.add('highlight-cell'); }
            
            const activeClueDisplay = document.getElementById('active-clue-display');
            const wordData = placedWords.find(w => w.number === wordNumber && w.isAcross === (direction === 'across'));
            if (wordData) {
                const dirText = direction === 'across' ? 'Melintang' : 'Menegak';
                activeClueDisplay.innerHTML = `
                    <div class="text-left w-full">
                        <div class="text-xs font-black text-[#F2629E] uppercase tracking-widest mb-1">${dirText} ${wordNumber}</div>
                        <h3 class="font-game text-2xl text-[#2D4059] mb-1">${wordData.peribahasa}</h3>
                        <p class="text-[#2D4059] font-bold text-md">${wordData.maksud}</p>
                    </div>`;
            }
            const clueEl = document.querySelector(`.clue-list li[data-number="${wordNumber}"][data-direction="${direction}"]`);
            if (clueEl) { clueEl.classList.add('active-clue'); clueEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }
        }

        // FUNGSI INPUT DAN AUTO-SEMAK
        function handleCellInput(e, x, y) {
            const input = e.target; 
            input.classList.remove('correct', 'revealed'); 
            input.value = input.value.toUpperCase();
            
            if (input.value.length === 1) moveToNextCell(x, y, 1);

            const allInputs = document.querySelectorAll('.cell-input');
            let anyEmpty = false;
            allInputs.forEach(i => { if (i.value === '') anyEmpty = true; });
            
            if (!anyEmpty && allInputs.length > 0) {
                setTimeout(() => checkAnswersLogic(), 300);
            }
        }

        function handleCellKeydown(e, x, y) {
            if (e.key === 'Backspace' && e.target.value === '') { e.preventDefault(); moveToNextCell(x, y, -1); } 
            else if (e.key === 'ArrowRight') { currentDirection = 'across'; moveToNextCell(x, y, 1); } 
            else if (e.key === 'ArrowLeft') { currentDirection = 'across'; moveToNextCell(x, y, -1); } 
            else if (e.key === 'ArrowDown') { currentDirection = 'down'; moveToNextCell(x, y, 1); } 
            else if (e.key === 'ArrowUp') { currentDirection = 'down'; moveToNextCell(x, y, -1); }
        }

        function moveToNextCell(x, y, step) {
            let nextX = currentDirection === 'across' ? x + step : x; let nextY = currentDirection === 'down' ? y + step : y;
            const nextCell = document.querySelector(`.grid-cell[data-x="${nextX}"][data-y="${nextY}"] input`);
            if (nextCell) nextCell.focus();
        }

        function playTadaAudio() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator(); const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination); osc.type = 'sine';
                osc.frequency.setValueAtTime(440, ctx.currentTime); osc.frequency.setValueAtTime(554.37, ctx.currentTime + 0.1); osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.2); osc.frequency.setValueAtTime(880, ctx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, ctx.currentTime); gain.gain.linearRampToValueAtTime(0.5, ctx.currentTime + 0.05); gain.gain.linearRampToValueAtTime(0, ctx.currentTime + 0.6);
                osc.start(ctx.currentTime); osc.stop(ctx.currentTime + 0.6);
            } catch(e) {}
        }

        function playRevealAudio() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const bufferSize = ctx.sampleRate * 0.3; const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
                const data = buffer.getChannelData(0); for (let i = 0; i < bufferSize; i++) data[i] = Math.random() * 2 - 1;
                const noise = ctx.createBufferSource(); noise.buffer = buffer;
                const filter = ctx.createBiquadFilter(); filter.type = 'bandpass'; filter.frequency.setValueAtTime(2000, ctx.currentTime); filter.frequency.exponentialRampToValueAtTime(200, ctx.currentTime + 0.3);
                const gain = ctx.createGain(); gain.gain.setValueAtTime(0, ctx.currentTime); gain.gain.linearRampToValueAtTime(0.3, ctx.currentTime + 0.1); gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                noise.connect(filter); filter.connect(gain); gain.connect(ctx.destination); noise.start();
            } catch(e) {}
        }

        // SEMAK MENGGUNAKAN BUTANG
        document.getElementById('btnCheck').addEventListener('click', () => {
            const allInputs = document.querySelectorAll('.cell-input');
            let anyEmpty = false;
            
            allInputs.forEach(input => {
                if (input.value === '') anyEmpty = true;
            });

            if (anyEmpty) {
                alert("Sila isi semua kotak kosong sebelum menyemak markah!");
                return;
            }

            checkAnswersLogic();
        });

        // FUNGSI UTAMA KIRA MARKAH (Penuh 100, Salah 1 perkataan tolak 10)
        function checkAnswersLogic() {
            let correctCount = 0;
            score = 0;

            placedWords.forEach(word => {
                const attr = word.isAcross ? 'data-across' : 'data-down';
                const wordInputs = document.querySelectorAll(`.grid-cell[${attr}="${word.number}"] .cell-input`);
                
                let isWordPerfect = true;
                
                wordInputs.forEach(input => {
                    const val = input.value.toUpperCase(); 
                    const correct = input.dataset.correctChar;
                    if (val !== correct) {
                        isWordPerfect = false;
                    }
                });

                wordInputs.forEach(input => {
                    const val = input.value.toUpperCase(); 
                    const correct = input.dataset.correctChar;
                    
                    input.classList.remove('correct', 'revealed');
                    if (val === correct) { 
                        input.classList.add('correct'); 
                    } else { 
                        input.value = correct; 
                        input.classList.add('revealed'); 
                    }
                    input.readOnly = true; 
                });

                if (isWordPerfect) {
                    correctCount++;
                }
            });

            // Markah: 100 penuh (Tolak 10 kalau salah)
            score = correctCount * 10;

            if (correctCount === placedWords.length) {
                playTadaAudio(); 
            } else {
                playRevealAudio();
            }

            setTimeout(() => triggerWinModal(score), 500);
        }

        function triggerWinModal(finalScore) {
            confetti({ particleCount: 200, spread: 120, origin: { y: 0.6 }, colors: ['#F2629E', '#FFD54F', '#61D8F9', '#A9E868'] });
            
            document.getElementById('scoreDisplay').innerText = finalScore + " / 100";

            const msg = document.getElementById('successMessage'); 
            const content = document.getElementById('successContent');
            msg.classList.remove('hidden'); 
            setTimeout(() => { msg.classList.remove('opacity-0'); content.classList.remove('scale-95'); content.classList.add('scale-100'); }, 10);
        }

        function resetBoard() {
            const msg = document.getElementById('successMessage'); 
            msg.classList.add('opacity-0');
            setTimeout(() => msg.classList.add('hidden'), 300);

            document.querySelectorAll('.cell-input').forEach(input => {
                input.value = '';
                input.classList.remove('correct', 'revealed');
                input.readOnly = false; 
            });

            score = 0;
        }

        window.onload = () => { generateCrossword(); renderGrid(); renderClues(); };
    </script>
</body>
</html>