<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KampungController extends Controller
{
    // Fungsi untuk memaparkan Game Keempat (Situasi Kampung)
    public function kuizSituasi()
    {
        // Pangkalan data khas untuk Game Kampung (Peribahasa jarang didengari)
        $soalan = [
            [
                'situasi' => 'Pak Abu mencangkul tanah, membaja, dan menyiram pokok tanaman di kebunnya setiap hari dengan penat lelah. Malangnya, semua pokok itu mati dirosakkan oleh serangan ulat dan musuh tanaman sebelum sempat dituai hasilnya.',
                'jawapan' => 'Hempas tulang tak berbalas jasa.',
                'pilihan' => [
                    'Hempas tulang tak berbalas jasa.',
                    'Siang terkenang-kenang, makan tak kenyang, tidur tak lena, mandi tak basah, berminyak tak licin.',
                    'Bagai gadis jolong menumbuk.',
                    'Hempas tulang berisi perut.'
                ]
            ],
            [
                'situasi' => 'Ali tidak berani melawan pembuli walaupun badannya lebih besar daripada mereka.',
                'jawapan' => 'Laksana lembu kasi,galak saja tidak melawan.',
                'pilihan' => [
                    'Seperti beruang tidur sebulan.',
                    'Laksana lembu kasi,galak saja tidak melawan.',
                    'Seperti ular sawa kekenyangan.',
                    'Siang terkenang-kenang, makan tak kenyang, tidur tak lena, mandi tak basah, berminyak tak licin.'
                ]
            ],
            [
                'situasi' => 'Pendirian pemuda itu sentiasa berubah-ubah mengikut keadaan sekeliling tanpa asas yang kukuh.',
                'jawapan' => 'Umpama kiambang di air, akar tidak jejak di bumi.',
                'pilihan' => [
                    'Lalang ditiup angin.',
                    'Seperti kera mendapat bunga.',
                    'Umpama kiambang di air, akar tidak jejak di bumi.',
                    'Bagai air di daun keladi.'
                ]
            ],
            [
                'situasi' => 'Pencuri itu lari bertempiaran dengan sangat laju sebaik sahaja menyedari kehadiran kereta peronda polis.',
                'jawapan' => 'Seperti belut digetir ekor.',
                'pilihan' => [
                    'Seperti belut digetir ekor.',
                    'Seperti lipas kudung.',
                    'Bagai anjing buruk kepala.',
                    'Lari lintang-pukang.'
                ]
            ],
            [
                'situasi' => 'Jawatan pengurus yang disandang oleh Encik Ali kini tidak selamat selepas syarikat itu diambil alih oleh pihak lain.',
                'jawapan' => 'Seperti abu di atas tunggul.',
                'pilihan' => [
                    'Menunggu retak menanti belah.',
                    'Seperti telur di hujung tanduk.',
                    'Bagaikan laying-layang putus tali.',
                    'Seperti abu di atas tunggul.'
                ]
            ],
            [
                'situasi' => 'Dua sahabat baik itu sentiasa kelihatan bersama ke mana sahaja mereka pergi di dalam kampung.',
                'jawapan' => 'Bagai beliung dengan asahan.',
                'pilihan' => [
                    'Bagai isi dengan kuku.',
                    'Bagai aur dengan tebing.',
                    'Bagai dakwat dengan kertas.',
                    'Bagai beliung dengan asahan.'
                ]
            ],
            [
                'situasi' => 'Kassim menawarkan diri untuk menanggung hutang rakannya, akhirnya dia sendiri yang jatuh muflis.',
                'jawapan' => 'Mendukung biawak hidup.',
                'pilihan' => [
                    'Harapkan pagar, pagar makan padi.',
                    'Mendukung biawak hidup.',
                    'Menolong anjing tersepit.',
                    'Lembu punya susu, sapi dapat nama.'
                ]
            ],
            [
                'situasi' => 'Secara diam-diam, pegawai itu memindahkan wang syarikat ke akaun peribadinya tanpa disedari sesiapa selama bertahun-tahun.',
                'jawapan' => 'Gunting makan di hujung.',
                'pilihan' => [
                    'Gunting makan di hujung.',
                    'Musuh dalam selimut.',
                    'Lempar batu sembunyi tangan.',
                    'Air tenang jangan disangka tiada buaya.'
                ]
            ],
            [
                'situasi' => 'Walaupun gajinya kecil, Ramli sanggup berhutang kad kredit semata-mata untuk memakai pakaian berjenama mewah.',
                'jawapan' => 'Biar papa asal bergaya.',
                'pilihan' => [
                    'Ukur baju di badan sendiri.',
                    'Besar pasak dari tiang.',
                    'Biar papa asal bergaya.',
                    'Gali lubang tutup lubang.'
                ]
            ],
            [
                'situasi' => 'Kanak-kanak itu melompat-lompat keseronokan apabila bapanya membelikannya sebuah basikal baharu.',
                'jawapan' => 'Bagai kacang direbus satu.',
                'pilihan' => [
                    'Macam kera dapat bunga.',
                    'Bagai itik pulang petang.',
                    'Bagai kacang direbus satu.',
                    'Seperti rusa masuk kampung.'
                ]
            ]
        ];

        // Rawakkan soalan dan pilihan jawapan
        shuffle($soalan);
        foreach ($soalan as &$s) {
            shuffle($s['pilihan']);
        }

        return view('peribahasa.kampung', compact('soalan'));
    }

    // (Pilihan) Jika anda memerlukan fungsi lobi dalam controller ini juga
    // berdasarkan route anda: Route::get('/peribahasa/lobby', [KampungController::class, 'lobby'])
    public function lobby()
    {
        return view('peribahasa.lobby');
    }
}