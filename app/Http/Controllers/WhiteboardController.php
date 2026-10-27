<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhiteboardController extends Controller
{
    // Susunan 10 soalan tetap untuk Tahap 1 (Bukan rawak)
    private $soalanTahap1 = [
        [
            'id' => 1,
            'maksud' => 'Bersiap sedia sebelum ditimpa kesusahan.',
            'jawapan' => 'Sediakan payung sebelum hujan',
            'pilihan' => ['Sudah jatuh ditimpa tangga', 'Nasi sudah menjadi bubur', 'Sediakan payung sebelum hujan', 'Bagai tikus membaiki labu']
        ],
        [
            'id' => 2,
            'maksud' => 'Melakukan sesuatu pekerjaan itu biarlah sehingga selesai dan berjaya.',
            'jawapan' => 'Alang-alang menyeluk pekasam, biar sampai ke pangkal lengan',
            'pilihan' => ['Genggam bara api biar sampai jadi arang', 'Alang-alang menyeluk pekasam, biar sampai ke pangkal lengan', 'Melepaskan batuk di tangga', 'Sehari selembar benang, lama-lama menjadi kain']
        ],
        [
            'id' => 3,
            'maksud' => 'Orang yang tidak tahu menghargai pemberian orang lain.',
            'jawapan' => 'Seperti kera mendapat bunga',
            'pilihan' => ['Seperti anjing dengan kucing', 'Seperti kera mendapat bunga', 'Bagai tikus membaiki labu', 'Kacang lupakan kulit']
        ],
        [
            'id' => 4,
            'maksud' => 'Hubungan yang sangat rapat dan saling bantu-membantu.',
            'jawapan' => 'Bagai aur dengan tebing',
            'pilihan' => ['Bagai isi dengan kuku', 'Air dicincang tidak akan putus', 'Bagai aur dengan tebing', 'Berat sama dipikul, ringan sama dijinjing']
        ],
        [
            'id' => 5,
            'maksud' => 'Mendidik anak biarlah ketika mereka masih kecil.',
            'jawapan' => 'Melentur buluh biarlah dari rebungnya',
            'pilihan' => ['Melentur buluh biarlah dari rebungnya', 'Di mana bumi dipijak, di situ langit dijunjung', 'Bapa borek anak rintik', 'Ke mana tumpahnya kuah kalau tidak ke nasi']
        ],
        [
            'id' => 6,
            'maksud' => 'Mempunyai niat tersembunyi di sebalik sesuatu perbuatan.',
            'jawapan' => 'Ada udang di sebalik batu',
            'pilihan' => ['Tanam tebu di tepi bibir', 'Musuh dalam selimut', 'Gunting dalam lipatan', 'Ada udang di sebalik batu']
        ],
        [
            'id' => 7,
            'maksud' => 'Orang yang lupa akan asal-usulnya apabila sudah senang.',
            'jawapan' => 'Kacang lupakan kulit',
            'pilihan' => ['Kacang lupakan kulit', 'Kaduk naik junjung', 'Ular menyusur akar', 'Seperti rusa masuk kampung']
        ],
        [
            'id' => 8,
            'maksud' => 'Menurut adat dan peraturan tempat yang kita diami.',
            'jawapan' => 'Di mana bumi dipijak, di situ langit dijunjung',
            'pilihan' => ['Masuk kandang kambing mengembek', 'Di mana bumi dipijak, di situ langit dijunjung', 'Hujan emas di negeri orang', 'Lain padang lain belalang']
        ],
        [
            'id' => 9,
            'maksud' => 'Keuntungan yang diharapkan tidak dapat, harta yang ada pula hilang.',
            'jawapan' => 'Mendengar guruh di langit, air di tempayan dicurahkan',
            'pilihan' => ['Yang dikejar tak dapat, yang dikendong berciciran', 'Mendengar guruh di langit, air di tempayan dicurahkan', 'Sudah jatuh ditimpa tangga', 'Menang sorak kampung tergadai']
        ],
        [
            'id' => 10,
            'maksud' => 'Sesuatu perkara itu tidak akan terjadi tanpa sebab atau puncanya.',
            'jawapan' => 'Kalau tiada angin masakan pokok bergoyang',
            'pilihan' => ['Sebab nila setitik rosak susu sebelanga', 'Sepandai-pandai tupai melompat akhirnya jatuh', 'Kalau tiada angin masakan pokok bergoyang', 'Bertepuk sebelah tangan tidak akan berbunyi']
        ]
    ];

    public function index()
    {
        return view('peribahasa.whiteboard');
    }

    public function getTahap1(Request $request)
    {
        // Tetapkan susunan supaya 100% sama setiap kali dimainkan
        $soalan = $this->soalanTahap1;
        
        // Kocok susunan pilihan jawapan (A,B,C,D) sahaja supaya tidak dihafal kedudukannya
        foreach ($soalan as &$s) {
            shuffle($s['pilihan']);
        }

        return response()->json([
            'status' => 'success',
            'data' => $soalan
        ]);
    }
}
