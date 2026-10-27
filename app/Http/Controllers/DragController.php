<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DragController extends Controller
{
    public function index()
    {
        // Data 5 pusingan peribahasa sifat jahat manusia
        $rounds = [
            [
                'round' => 1,
                
                'maksud' => 'Orang yang dianggap kawan, tetapi sebenarnya berbuat jahat dan mengkhianati kita secara diam-diam.',
                'fullText' => 'MUSUH DALAM [  ]',
                'jawapan' => 'SELIMUT'
            ],
            [
                'round' => 2,
                
                'maksud' => 'Orang yang tidak jujur, bercakap manis di depan tetapi menusuk dari belakang.',
                'fullText' => '[   ] DUA MUKA',
                'jawapan' => 'TALAM'
            ],
            [
                'round' => 3,
                
                'maksud' => 'Orang yang kita harapkan untuk menjaga harta, dialah yang merosakkannya.',
                'fullText' => 'HARAPKAN [  ], PAGAR MAKAN PADI',
                'jawapan' => 'PAGAR'
            ],
            [
                'round' => 4,
                
                'maksud' => 'Orang yang melakukan tipu helah dan menganiaya mangsanya secara licik tanpa disedari.',
                'fullText' => 'SEPERTI [  ] MAKAN DI HUJUNG',
                'jawapan' => 'GUNTING'
            ],
            [
                'round' => 5,
    
                'maksud' => ' Mencari keuntungan atau mengambil kesempatan peribadi dalam keadaan yang sedang kacau, huru-hara, atau susah.',
                'fullText' => 'MENANGGUK DI AIR [  ]',
                'jawapan' => 'KERUH'
            ],

            [
                'round' => 6,
                'maksud' => 'Sesuatu kejadian itu berlaku kerana terlalu banyak diperkatakan orang ',
                'fullText' => 'BUKANNYA [  ] PANAS',
                'jawapan' => 'DIRETAK'

            ],
            [   'round' => 7,
                'maksud' => ' Orang bodoh yang sombong, tiada sedar dirinya dibodohi orang.',
                'fullText' => 'BAGAI [  ] KERBAU RAMPUNG',
                'jawapan' => 'JELONGAK'
            ],
            [   'round' => 8,
                'maksud' => ' Tak dapat berbuat apa-apa kerana kehabisan daya.',
                'fullText' => 'BURUNG HANTU [  ]',
                'jawapan' => 'KESIANGAN'
            ],
            [   'round' => 9,
                'maksud' => 'Keburukan, kerugian, atau kesusahan hendak ditanggung atau dibebankan bersama orang lain, tetapi keuntungan atau kesenangan diambil dan dinikmati seorang diri ',
                'fullText' => 'Buruk [ ] pada orang, elok dipilih sama seorang',
                'jawapan' => 'DIKEMBANG'
            ],
            [   'round' => 10,
                'maksud' => 'Kelihatannya baik tetapi di dalam atau keadaan yang sebenarnya jahat ',
                'fullText' => 'BULAT BERSEGI [  ] MELUKAI',
                'jawapan' => 'BERSANDING'
            ],
        ];

        return view('peribahasa.drag', compact('rounds'));
    }
}