<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeribahasaController extends Controller
{
    // Function untuk Menu Utama
    public function lobby()
    {
        return view('peribahasa.lobby');
    }

    public function crossword()
    {
        // Data Peribahasa dari DBP (Susunan tetap dari 1 hingga 10)
        $senaraiPeribahasa = [
            ["peribahasa" => "Bagai aur dengan ...", "jawapan" => "TEBING", "maksud" => "Hubungan yang rapat dan saling membantu."],
            ["peribahasa" => "Bapa borek, anak ...", "jawapan" => "RINTIK", "maksud" => "Sifat anak biasanya mengikut sifat bapanya."],
            ["peribahasa" => "Air dicincang tidak akan ...", "jawapan" => "PUTUS", "maksud" => "Perbalahan antara adik-beradik tidak akan berpanjangan."],
            ["peribahasa" => "Melentur buluh biarlah dari ...", "jawapan" => "REBUNG", "maksud" => "Mendidik anak biarlah semenjak mereka kecil lagi."],
            ["peribahasa" => "Seperti katak di bawah ...", "jawapan" => "TEMPURUNG", "maksud" => "Orang yang cetek pengetahuannya dan sempit pandangan."],
            ["peribahasa" => "Biar mati anak, jangan mati ...", "jawapan" => "ADAT", "maksud" => "Adat resam warisan bangsa wajib dipelihara."],
            ["peribahasa" => "Genggam bara api biar sampai jadi ...", "jawapan" => "ARANG", "maksud" => "Mengerjakan sesuatu yang sukar hendaklah sabar sehingga berjaya."],
            ["peribahasa" => "Harapkan pagar, pagar makan ...", "jawapan" => "PADI", "maksud" => "Dikhianati oleh orang yang diberi kepercayaan."],
            ["peribahasa" => "Ukur baju di badan ...", "jawapan" => "SENDIRI", "maksud" => "Lakukan sesuatu mengikut kemampuan diri sendiri."],
            ["peribahasa" => "Lempar batu sembunyi ...", "jawapan" => "TANGAN", "maksud" => "Melakukan kejahatan tetapi berpura-pura tidak tahu."]
        ];

        

        // Controller hantar data ke View blade (Paparan)
        return view('peribahasa.crossword', [
            'peribahasaData' => $senaraiPeribahasa
        ]);
    }


    public function taman()
{
    return view('peribahasa.taman');
}
}