<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Permainan Peribahasa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Tema Warna Butang */
            --btn-pink: #F2629E; --btn-pink-shadow: #D2427E;
            --btn-yellow: #FFD54F; --btn-yellow-shadow: #DCA92D;
            --btn-blue: #55B4D6; --btn-blue-shadow: #4392AE;
            --btn-green: #8CC63F; --btn-green-shadow: #709D32;
            --btn-orange: #F59E0B; --btn-orange-shadow: #B45309; 
            --btn-purple: #A855F7; --btn-purple-shadow: #7E22CE; 
            --btn-red: #EF4444; --btn-red-shadow: #B91C1C;
            --btn-taman: #10B981; --btn-taman-shadow: #047857;
            --text-dark: #2D4059;
            --bg-school: #F8FAFC; 
        }

        /* 1. ANIMASI GRID BERGERAK (SCROLLING BACKGROUND) */
        body { 
            background-color: var(--bg-school); 
            background-image: radial-gradient(#CBD5E1 3px, transparent 3px);
            background-size: 40px 40px;
            color: var(--text-dark); 
            font-family: 'Nunito', sans-serif; 
            min-height: 100vh; 
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: scrollGrid 4s linear infinite;
        }

        @keyframes scrollGrid {
            0% { background-position: 0px 0px; }
            100% { background-position: -40px 40px; }
        }

        .font-game { font-family: 'Fredoka One', cursive; letter-spacing: 1px; }

        /* 2. ELEMEN GEOMETRI TERAPUNG */
        .bg-shape {
            position: fixed;
            z-index: 0;
            pointer-events: none;
            font-family: 'Fredoka One', cursive;
            opacity: 0.25;
            filter: drop-shadow(0 10px 10px rgba(0,0,0,0.1));
        }

        .anim-float-1 { animation: float1 8s ease-in-out infinite; }
        .anim-float-2 { animation: float2 10s ease-in-out infinite reverse; }
        .anim-float-3 { animation: float3 12s ease-in-out infinite; }

        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(30px, -40px) rotate(15deg) scale(1.1); }
        }
        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-30px, 40px) rotate(-15deg) scale(0.9); }
        }
        @keyframes float3 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(40px, 20px) rotate(25deg) scale(1.15); }
        }

        /* 3. KOTAK LOBI UTAMA */
        .lobby-board {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 8px solid var(--btn-blue); 
            border-radius: 40px;
            box-shadow: 
                0 15px 0 var(--btn-blue-shadow),
                0 25px 40px rgba(0,0,0,0.15), 
                inset 0 0 0 6px #EAF6F9;
            position: relative;
            z-index: 10;
            animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        @keyframes popIn {
            0% { transform: scale(0.7); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .lobby-board::before, .lobby-board::after {
            content: ''; position: absolute; top: 15px; width: 16px; height: 16px; 
            background-color: var(--btn-yellow); border-radius: 50%; 
            box-shadow: inset -3px -3px 0 rgba(0,0,0,0.1), 2px 4px 4px rgba(0,0,0,0.15);
        }
        .lobby-board::before { left: 15px; }
        .lobby-board::after { right: 15px; }

        /* 4. BUTANG TIMBUL 3D */
        .chunky-btn {
            font-family: 'Fredoka One', cursive;
            font-size: 1.15rem;
            padding: 1rem 1.5rem;
            border-radius: 24px;
            transition: all 0.1s ease-in-out;
            cursor: pointer;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            color: white;
            text-shadow: 0 2px 0 rgba(0,0,0,0.1);
        }
        
        .chunky-btn:active {
            transform: translateY(8px);
            margin-bottom: 8px;
            border-bottom-width: 0px !important;
        }
        .chunky-btn:hover { filter: brightness(1.05); transform: translateY(-2px); }

        /* Warna Butang */
        .btn-crossword { background-color: var(--btn-blue); border-bottom: 8px solid var(--btn-blue-shadow); }
        .btn-snake { background-color: var(--btn-green); border-bottom: 8px solid var(--btn-green-shadow); }
        .btn-whiteboard { background-color: var(--btn-pink); border-bottom: 8px solid var(--btn-pink-shadow); }
        .btn-kampung { background-color: var(--btn-orange); border-bottom: 8px solid var(--btn-orange-shadow); }
        .btn-sifat-jahat { background-color: var(--btn-purple); border-bottom: 8px solid var(--btn-purple-shadow); }
        .btn-baling { background-color: var(--btn-red); border-bottom: 8px solid var(--btn-red-shadow); }
        .btn-taman { background-color: var(--btn-taman); border-bottom: 8px solid var(--btn-taman-shadow); }
    </style>
</head>
<body class="p-6 overflow-x-hidden">

    <!-- ELEMEN GEOMETRI TERAPUNG -->
    <div class="bg-shape anim-float-1 text-[var(--btn-pink)] text-7xl" style="top: 10%; left: 10%;">✖</div>
    <div class="bg-shape anim-float-2 text-[var(--btn-yellow)] text-8xl" style="top: 15%; right: 15%;">⬤</div>
    <div class="bg-shape anim-float-3 text-[var(--btn-green)] text-9xl" style="bottom: 10%; left: 15%;">▲</div>
    <div class="bg-shape anim-float-1 text-[var(--btn-blue)] text-7xl" style="bottom: 20%; right: 10%;">✖</div>

    <!-- Papan Lobi Utama -->
    <div class="lobby-board w-full max-w-lg p-8 md:p-10 flex flex-col items-center text-center my-auto">
        
        <!-- Ikon Logo -->
        <div class="text-6xl mb-3 drop-shadow-md">🎮</div>

        <h1 class="font-game text-4xl md:text-5xl text-[#F2629E] mb-2" style="-webkit-text-stroke: 1px #D2427E;">
            Portal Peribahasa
        </h1>
        <p class="text-[#2D4059] mb-6 font-bold text-base bg-[#F8FDFE] px-6 py-2 rounded-full border-2 border-[#EAF6F9]">
            Pilih permainan minda anda hari ini!
        </p>
        
        <div class="flex flex-col gap-4 w-full">
            
            <!-- Butang ke Game Crossword -->
            <a href="{{ route('peribahasa.crossword') }}" class="chunky-btn btn-crossword">
                <span class="text-2xl">🧩</span> Main Teka Silang Kata
            </a>
            
            {{-- 
                BUTANG ULAR TANGGA DISEMBUNYIKAN SEMENTARA WAKTU (UNCOMMENT UNTUK PAPARKAN SEMULA)
                <a href="{{ route('peribahasa.ular') }}" class="chunky-btn btn-snake">
                    <span class="text-2xl">🐍</span> Main Ular & Tangga  
                </a>
            --}}

            <!-- Butang ke Game Papan Putih -->
            <a href="{{ route('peribahasa.whiteboard') }}" class="chunky-btn btn-whiteboard">
                <span class="text-2xl">📝</span> Padan Makna Peribahasa
            </a>

            <!-- Butang ke Game Situasi Kampung -->
            <a href="{{ route('game.situasi') }}" class="chunky-btn btn-kampung">
                <span class="text-2xl">🛖</span> Teka Situasi 
            </a>

            <!-- Butang ke Game Sifat Jahat Manusia -->
            <a href="{{ route('game.sifat.jahat') }}" class="chunky-btn btn-sifat-jahat">
                <span class="text-2xl">🧩</span> Cabaran Minda 
            </a>

            <!-- Butang ke Game Baling Craftverse (3D) -->
            <a href="{{ route('game.baling') }}" class="chunky-btn btn-baling">
                <span class="text-2xl">🧱</span> Craftverse
            </a>

        </div>
    </div>

</body>
</html>