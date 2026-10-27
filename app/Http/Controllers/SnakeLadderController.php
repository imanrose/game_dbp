<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoalanPeribahasa;

class SnakeLadderController extends Controller
{
    // Konfigurasi Papan
    private $ladders = [3 => 22, 5 => 8, 11 => 26, 20 => 29, 27 => 84, 40 => 59, 51 => 67, 71 => 91];
    private $snakes = [17 => 4, 19 => 7, 54 => 34, 64 => 60, 87 => 24, 93 => 73, 95 => 75, 99 => 78];

    public function index(Request $request)
    {
        if ($request->query('reset')) {
            $request->session()->put('sl_position', 1);
            $request->session()->put('sl_score', 0);
            return redirect()->route('peribahasa.ular');
        }

        if (!$request->session()->has('sl_position')) {
            $request->session()->put('sl_position', 1);
            $request->session()->put('sl_score', 0);
        }
        return view('peribahasa.snake_ladder');
    }

    public function rollDice(Request $request)
    {
        $dice = rand(1, 6); 
        $currentPos = $request->session()->get('sl_position', 1);
        $newPos = $currentPos + $dice;
        if ($newPos > 100) $newPos = 100;

        $eventType = 'normal';
        $targetPos = $newPos;

        if (array_key_exists($newPos, $this->ladders)) {
            $eventType = 'ladder'; 
            $targetPos = $this->ladders[$newPos];
        } elseif (array_key_exists($newPos, $this->snakes)) {
            $eventType = 'snake'; 
            $targetPos = $this->snakes[$newPos];
        }

        $soalanRaw = SoalanPeribahasa::inRandomOrder()->first();
        if(!$soalanRaw) {
            return response()->json(['error' => 'Sila run seeder'], 500);
        }
        
        $pilihan = [$soalanRaw->jawapan_betul, $soalanRaw->pilihan_salah_1, $soalanRaw->pilihan_salah_2];
        shuffle($pilihan);
        
        $soalan = [
            'id' => $soalanRaw->id,
            'klu' => $soalanRaw->klu_soalan,
            'pilihan' => $pilihan,
            'maksud' => $soalanRaw->maksud_lengkap
        ];

        $request->session()->put('sl_temp_target', $targetPos);
        $request->session()->put('sl_temp_current', $newPos);

        return response()->json([
            'dice' => $dice, 
            'newPos' => $newPos, 
            'hasEvent' => true,
            'eventType' => $eventType, 
            'soalan' => $soalan, 
            'score' => $request->session()->get('sl_score')
        ]);
    }

    public function submitAnswer(Request $request)
    {
        $soalan = SoalanPeribahasa::find($request->soalan_id);
        $isCorrect = ($soalan->jawapan_betul === $request->jawapan);
        
        $currentPos = $request->session()->get('sl_temp_current');
        $score = $request->session()->get('sl_score');
        $finalPos = $currentPos;
        $mesejPopup = "";

        // LOGIK PERGERAKAN BAHARU & PEMARKAHAN
        if ($request->event_type == 'ladder') {
            if ($isCorrect) { 
                $finalPos = $currentPos + 2; // Naik 2 petak
                $score += 5; 
                $mesejPopup = "Hebat! Anda naik 2 petak!";
            } else { 
                $finalPos = $currentPos; // Tiada apa-apa terjadi
                $score -= 3;
                $mesejPopup = "Salah! Tiada apa-apa terjadi.";
            } 
        } else if ($request->event_type == 'snake') {
            if ($isCorrect) { 
                $finalPos = $currentPos; // Kekal selamat
                $score += 5; 
                $mesejPopup = "Fuh! Anda SELAMAT dari termakan ular!";
            } else { 
                $finalPos = $currentPos - 2; // Turun 2 petak
                if ($finalPos < 1) $finalPos = 1; // Jangan bagi jatuh bawah petak 1
                $score -= 5;
                $mesejPopup = "Alamak! Salah jawab, anda ditelan ular & turun 2 petak!";
            } 
        } else {
            $finalPos = $currentPos;
            if ($isCorrect) { 
                $score += 5; 
                $mesejPopup = "Jawapan Tepat!";
            } else { 
                $score -= 3; 
                $mesejPopup = "Jawapan Salah! Cuba lagi nanti.";
            }
        }

        // HAD MARKAH: Maksimum 100, Minimum 0
        if ($score > 100) $score = 100;
        if ($score < 0) $score = 0;

        $request->session()->put('sl_position', $finalPos);
        $request->session()->put('sl_score', $score);

        return response()->json([
            'isCorrect' => $isCorrect, 
            'finalPos' => $finalPos,
            'score' => $score, 
            'jawapanBetul' => $soalan->jawapan_betul,
            'mesej' => $mesejPopup // Hantar mesej ke depan untuk pop-up
        ]);
    }
}