<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeribahasaController;
use App\Http\Controllers\SnakeLadderController; 
use App\Http\Controllers\WhiteboardController;
use App\Http\Controllers\KampungController; // <-- TAMBAH BARIS INI
use App\Http\Controllers\PeribahasaJahatController;
use App\Http\Controllers\DragController; // Tambah Controller Drag baharu
use App\Http\Controllers\BalingController;
// ==========================================
// 1. LALUAN KE HALAMAN MENU UTAMA (LOBBY)
// ==========================================
Route::get('/', [PeribahasaController::class, 'lobby'])->name('peribahasa.lobby');


// ==========================================
// 2. LALUAN KE GAME SILANG KATA
// ==========================================
Route::get('/crossword', [PeribahasaController::class, 'crossword'])->name('peribahasa.crossword');


// ==========================================
// 3. LALUAN KE GAME ULAR, TANGGA & SI BULUS
// ==========================================
Route::get('/ular-tangga', [SnakeLadderController::class, 'index'])->name('peribahasa.ular');
Route::post('/ular-tangga/roll', [SnakeLadderController::class, 'rollDice']);
Route::post('/ular-tangga/answer', [SnakeLadderController::class, 'submitAnswer']);


// ==========================================
// 4. LALUAN KE GAME PAPAN PUTIH (WHITEBOARD)
// ==========================================
Route::get('/whiteboard', [WhiteboardController::class, 'index'])->name('peribahasa.whiteboard');
Route::get('/whiteboard/tahap-1', [WhiteboardController::class, 'getTahap1']);


// ==========================================
// 5. LALUAN KE GAME SITUASI KAMPUNG
// ==========================================
// Route untuk game situasi
Route::get('/peribahasa/Kampung', [KampungController::class, 'kuizSituasi'])->name('game.situasi');

// Pastikan anda ada route lobi (contoh)
Route::get('/peribahasa/lobby', [KampungController::class, 'lobby'])->name('game.lobby');


// ==========================================
// 6. LALUAN KE GAME SIFAT JAHAT (DRAG & DROP)
// ==========================================
Route::get('/peribahasa/drag', [DragController::class, 'index'])->name('game.sifat.jahat');

Route::get('/baling-peribahasa', fn () => response()->file(public_path('baling/index.html')))->name('game.baling');