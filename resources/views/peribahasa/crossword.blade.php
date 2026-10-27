<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Teka Silang Kata - Tema Taman Ceria</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&family=Poppins:wght@500;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            /* Tema Flat Design Ceria */
            --sky-blue: #E0F7FA;
            --grass-green: #E8F5E9;
            --btn-pink: #F2629E;
            --btn-pink-shadow: #D2427E;
            --btn-yellow: #FFD54F;
            --btn-yellow-shadow: #DCA92D;
            --text-dark: #2D4059;
            
            /* Warna Papan Silang Kata Pastel */
            --board-pastel: #E1F5FE; 
            --board-pastel-border: #B3E5FC;
            --cell-bg: #FFFFFF;
        }

        body { 
            /* Latar Belakang Plain Pastel Kecerunan Lembut */
            background-color: #FCE4EC; 
            background-image: linear-gradient(135deg, #FCE4EC 0%, #EDE7F6 50%, #E0F7FA 100%);
            background-attachment: fixed;
            
            color: var(--text-dark); 
            font-family: 'Nunito', sans-serif; 
            min-height: 100vh; 
            overflow-x: hidden;
        }

        .font-game { font-family: 'Fredoka One', cursive; letter-spacing: 1px; }
        .font-heading { font-family: 'Poppins', sans-serif; }

        /* Papan Silang Kata Wrapper Responsif */
        #crossword-wrapper { 
            background: var(--board-pastel); 
            padding: 12px; 
            border-radius: 28px; 
            box-shadow: inset 0 0 0 4px var(--board-pastel-border), 0 10px 20px rgba(0, 0, 0, 0.05); 
            border: 5px solid white; 
            margin: 0 auto; 
            width: fit-content; 
            max-width: 100%;
        }

        @media (min-width: 768px) {
            #crossword-wrapper {
                padding: 20px;
                border-radius: 36px;
                box-shadow: inset 0 0 0 6px var(--board-pastel-border), 0 15px 30px rgba(0, 0, 0, 0.05);
                border: 8px solid white;
            }
        }

        #crossword-board { 
            display: grid; 
            gap: 2px; 
            background-color: transparent; 
            border: none; 
        }

        @media (min-width: 768px) {
            #crossword-board {
                gap: 4px;
            }
        }

        /* Saiz Kotak Responsif: Kecil di telefon, kemas di desktop */
        .grid-cell { 
            width: 22px; 
            height: 22px; 
            background-color: transparent; 
            position: relative; 
        }

        @media (min-width: 480px) {
            .grid-cell { width: 28px; height: 28px; }
        }

        @media (min-width: 768px) {
            .grid-cell { width: 34px; height: 34px; }
        }

        @media (min-width: 1280px) {
            .grid-cell { width: 38px; height: 38px; }
        }
        
        /* Gaya Kotak Silang Kata 3D Terapung */
        .grid-cell.active { 
            background-color: var(--cell-bg); 
            border: 2px solid #EAF6F9;
            border-radius: 6px;
            box-shadow: 0 2px 0 #DDF1F6;
            transition: all 0.2s ease; 
        }

        @media (min-width: 768px) {
            .grid-cell.active {
                border: 2.5px solid #EAF6F9;
                border-radius: 10px;
                box-shadow: 0 3px 0 #DDF1F6;
            }
        }
        
        .grid-cell.highlight-word { background-color: #FFF0F5; border-color: #FFB6C1; box-shadow: 0 2px 0 #FF9EAE; }
        .grid-cell.highlight-cell { background-color: #FFFFFF; transform: scale(1.15); z-index: 10; border-color: #F2629E; box-shadow: 0 4px 0 #D2427E; }

        .cell-input { 
            width: 100%; height: 100%; border: none; background: transparent; text-align: center; 
            font-size: 0.85rem; font-weight: 900; font-family: 'Poppins', sans-serif; 
            text-transform: uppercase; outline: none; cursor: pointer; padding: 0; 
            color: var(--text-dark); transition: color 0.3s ease; 
        }

        @media (min-width: 480px) {
            .cell-input { font-size: 1.05rem; }
        }

        @media (min-width: 768px) {
            .cell-input { font-size: 1.25rem; }
        }
        
        .cell-input.correct { color: #2ed573; text-shadow: 1px 1px 0px rgba(0,0,0,0.1); } 
        .cell-input.revealed { color: #ff4757; animation: popText 0.3s ease-out; } 
        
        @keyframes popText { 0% { transform: scale(0.5); opacity: 0; } 50% { transform: scale(1.2); } 100% { transform: scale(1); opacity: 1; } }
        
        .cell-number { 
            position: absolute; 
            top: 1px; 
            left: 2px; 
            font-size: 0.55rem; 
            font-weight: 800; 
            pointer-events: none; 
            color: var(--text-dark); 
            opacity: 0.6; 
            line-height: 1;
        }

        @media (min-width: 768px) {
            .cell-number { font-size: 0.65rem; top: 2px; left: 3px; }
        }
        
        /* Senarai Pembayang Gaya Butang Ceria */
        .clue-list li { 
            margin-bottom: 10px; cursor: pointer; padding: 10px 14px; 
            border-radius: 16px; background-color: #ffffff; 
            border: 3px solid transparent; 
            box-shadow: 0 3px 0 #EAF6F9; 
            transition: all 0.2s; 
        }
        .clue-list li:hover { transform: translateY(-2px); box-shadow: 0 5px 0 #DDF1F6; }
        .clue-list li.active-clue { background-color: #FFF0F5; border-color: #FFB6C1; box-shadow: 0 4px 0 #FF9EAE; }

        /* Butang Timbul */
        .btn-pink { background-color: var(--btn-pink); color: white; border-bottom: 6px solid var(--btn-pink-shadow); transition: all 0.1s; }
        .btn-pink:active { transform: translateY(6px); border-bottom: 0px solid var(--btn-pink-shadow); margin-bottom: 6px; }
        .btn-yellow { background-color: var(--btn-yellow); color: var(--text-dark); border-bottom: 6px solid var(--btn-yellow-shadow); transition: all 0.1s; }
        .btn-yellow:active { transform: translateY(6px); border-bottom: 0px solid var(--btn-yellow-shadow); margin-bottom: 6px; }
        .btn-red { background-color: #ff4757; color: white; border-bottom: 6px solid #ff0000; transition: all 0.1s; }
        .btn-red:active { transform: translateY(6px); border-bottom: 0px solid #ff0000; margin-bottom: 6px; }

        /* Butang Keluar Atas Kiri */
        .btn-exit-top {
            position: fixed;
            top: 16px; left: 16px;
            background-color: #ff4757;
            color: white;
            border-bottom: 5px solid #ff0000;
            border-radius: 50%;
            width: 46px; height: 46px;
            display: flex; justify-content: center; align-items: center;
            font-size: 1.25rem; font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.1s;
            z-index: 50;
            text-decoration: none;
        }
        .btn-exit-top:active {
            transform: translateY(5px);
            border-bottom-width: 0px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body class="py-6 px-3 md:px-8">

    <!-- Butang Keluar ke Lobi -->
    <a href="{{ route('peribahasa.lobby') }}" class="btn-exit-top" title="Keluar ke Menu Utama">
        ✖
    </a>

    <div class="max-w-7xl mx-auto relative z-10">
        
        <header class="text-center mb-4 w-full relative z-10 flex flex-col items-center justify-center mt-1">
            <span class="bg-[#F2629E] text-white text-xs md:text-sm font-black px-4 py-1.5 md:px-5 md:py-2 rounded-full uppercase tracking-widest mb-2 shadow-[0_3px_0_#D2427E] border-2 border-white">Dewan Bahasa dan Pustaka</span>
            <h1 class="font-game text-3xl md:text-5xl text-[#FFD54F] mb-2 uppercase tracking-widest" style="-webkit-text-stroke: 1.5px white; text-shadow: 0 3px 0 rgba(0,0,0,0.1);">
                Teka Silang Kata
            </h1>
            <p class="text-xs md:text-base font-bold text-[#2D4059] bg-white/90 px-4 py-1.5 rounded-full shadow-sm backdrop-blur-sm border-2 border-white">Lengkapkan semua kotak untuk melihat markah penuh!</p>
        </header>

        <main class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-4">
            <div class="xl:col-span-2 flex flex-col items-center w-full">
                <div id="active-clue-display" class="w-full max-w-2xl bg-white border-3 md:border-4 border-[#B3E5FC] shadow-[0_6px_0_#81D4FA] rounded-[20px] p-4 md:p-5 mb-5 transition-all duration-300 min-h-[85px] flex items-center justify-center text-center">
                    <p class="text-[#2D4059] font-bold text-base md:text-lg italic">Pilih kotak putih untuk mula meneka.</p>
                </div>
                
                <!-- Kawasan Skrol Papan Silang Kata -->
                <div class="overflow-x-auto w-full pb-4 flex justify-center touch-pan-x touch-pan-y">
                    <div id="crossword-wrapper"><div id="crossword-board"></div></div>
                </div>
                
                <div class="w-full max-w-2xl mt-3 flex justify-center xl:justify-end">
                    <button id="btnCheck" class="btn-pink font-game px-6 py-3.5 md:px-8 md:py-4 rounded-full text-lg md:text-xl shadow-sm flex items-center gap-3">
                        <span>HANTAR & SEMAK JAWAPAN</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </button>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-md p-5 md:p-7 rounded-[32px] border-4 border-white shadow-[0_15px_30px_rgba(0,0,0,0.05)] h-fit flex flex-col gap-5 max-h-[600px] xl:max-h-[750px] overflow-y-auto">
                <h2 class="font-game text-2xl md:text-3xl text-[#F2629E] flex items-center gap-2 border-b-4 border-white/50 pb-3" style="-webkit-text-stroke: 1px white;">💡 Pembayang</h2>
                <div>
                    <h3 class="font-game text-sm md:text-base text-white bg-[#81D4FA] border-b-3 border-[#4FC3F7] px-3.5 py-1.5 rounded-xl mb-3 uppercase tracking-wider inline-block">Melintang</h3>
                    <ul id="clues-across" class="clue-list text-sm md:text-base"></ul>
                </div>
                <div class="mt-1">
                    <h3 class="font-game text-sm md:text-base text-[#2D4059] bg-[#FFD54F] border-b-3 border-[#DCA92D] px-3.5 py-1.5 rounded-xl mb-3 uppercase tracking-wider inline-block">Menegak</h3>
                    <ul id="clues-down" class="clue-list text-sm md:text-base"></ul>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Menang -->
    <div id="successMessage" class="fixed inset-0 bg-[#2D4059]/80 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-opacity duration-300 z-[60] px-4">
        <div class="bg-white rounded-[36px] p-6 md:p-10 max-w-md w-full text-center border-6 md:border-8 border-[#C8E6C9] shadow-[0_15px_0_rgba(0,0,0,0.1)] transform scale-95 transition-transform duration-300" id="successContent">
            <div class="text-6xl md:text-7xl mb-3">🏆</div>
            <h2 class="font-game text-3xl md:text-4xl text-[#F2629E] mb-2">Hebat!</h2>
            <p class="text-base md:text-lg font-bold text-[#2D4059] mb-5">Teka silang kata telah disemak sepenuhnya.</p>
            
            <div class="bg-[#F8FDFE] p-4 md:p-5 rounded-[24px] mb-6 border-4 border-[#FFE4E1]">
                <p class="text-sm md:text-base font-black text-[#2D4059] uppercase tracking-widest mb-1">Markah Akhir Anda</p>
                <p class="text-4xl md:text-5xl font-game text-[#FFD54F]" id="scoreDisplay" style="-webkit-text-stroke: 1.5px #DCA92D;">0 / 100</p>
            </div>

            <div class="flex flex-col gap-3">
                <button onclick="resetBoard()" class="w-full btn-yellow font-game px-5 py-3 rounded-full text-lg shadow-sm">
                    🔄 MAIN SEMULA
                </button>
                <a href="{{ route('peribahasa.lobby') }}" class="w-full text-center block btn-red font-game px-5 py-3 rounded-full text-lg shadow-sm">
                    ✖ KELUAR LOBI
                </a>
            </div>
        </div>
    </div>

    <!-- Logik Pengiraan dan Paparan Grid -->
    <script>
        const peribahasaDB = @json($peribahasaData);

        const BOARD_SIZE = 16; 
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

        function generateCrossword() {
            let fixedPool = [...peribahasaDB].slice(0, 10);
            
            initGrid(); 
            placedWords = []; 
            let wordCounter = 1;
            let pool = [...fixedPool];
            
            if (pool.length === 0) return;

            const firstWord = pool.shift();
            const startX = Math.floor((BOARD_SIZE - firstWord.jawapan.length) / 2);
            const startY = Math.floor(BOARD_SIZE / 2);
            placeWord(firstWord, startX, startY, true, wordCounter++);

            for (const wordObj of pool) {
                const word = wordObj.jawapan; 
                let bestPlacement = null;
                
                for (let y = 0; y < BOARD_SIZE; y++) {
                    for (let x = 0; x < BOARD_SIZE; x++) {
                        const resAcross = canPlaceWord(word, x, y, true);
                        if (resAcross.canPlace && resAcross.intersections > 0) {
                            if (!bestPlacement || resAcross.intersections > bestPlacement.intersections) {
                                bestPlacement = { x, y, isAcross: true, intersections: resAcross.intersections };
                            }
                        }
                        const resDown = canPlaceWord(word, x, y, false);
                        if (resDown.canPlace && resDown.intersections > 0) {
                            if (!bestPlacement || resDown.intersections > bestPlacement.intersections) {
                                bestPlacement = { x, y, isAcross: false, intersections: resDown.intersections };
                            }
                        }
                    }
                }
                
                if (bestPlacement) {
                    placeWord(wordObj, bestPlacement.x, bestPlacement.y, bestPlacement.isAcross, wordCounter++);
                } else {
                    let placedFallback = false;
                    for (let y = 0; y < BOARD_SIZE && !placedFallback; y++) {
                        for (let x = 0; x < BOARD_SIZE && !placedFallback; x++) {
                            const resAcross = canPlaceWord(word, x, y, true);
                            if (resAcross.canPlace) {
                                placeWord(wordObj, x, y, true, wordCounter++);
                                placedFallback = true;
                            } else {
                                const resDown = canPlaceWord(word, x, y, false);
                                if (resDown.canPlace) {
                                    placeWord(wordObj, x, y, false, wordCounter++);
                                    placedFallback = true;
                                }
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
                    <div class="flex gap-2.5">
                        <span class="font-game text-[#F2629E] text-xl mt-0.5">${word.number}.</span> 
                        <div>
                            <span class="font-bold text-[#2D4059] text-base">${word.peribahasa}</span>
                            <div class="text-xs md:text-sm font-semibold text-[#2D4059]/70 mt-0.5">${word.maksud}</div>
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
                        <div class="text-[11px] font-black text-[#F2629E] uppercase tracking-widest mb-0.5">${dirText} ${wordNumber}</div>
                        <h3 class="font-game text-lg md:text-xl text-[#2D4059] mb-0.5">${wordData.peribahasa}</h3>
                        <p class="text-[#2D4059] font-bold text-xs md:text-sm">${wordData.maksud}</p>
                    </div>`;
            }
            const clueEl = document.querySelector(`.clue-list li[data-number="${wordNumber}"][data-direction="${direction}"]`);
            if (clueEl) { clueEl.classList.add('active-clue'); clueEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }
        }

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

        document.getElementById('btnCheck').addEventListener('click', () => {
            const allInputs = document.querySelectorAll('.cell-input');
            let anyEmpty = false;
            
            allInputs.forEach(input => {
                if (input.value === '') anyEmpty = true;
            });

            if (anyEmpty) {
                alert("Sila isi semua kotak kosong sebelum menyemak jawapan!");
                return;
            }

            checkAnswersLogic();
        });

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