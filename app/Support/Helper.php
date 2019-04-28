<?php

use Carbon\Carbon;
use App\Models\{Kustomisasi, Post};

if (!function_exists('getHariFromCarbon')) {
    /**
     * Mendapatkan nama hari dari object carbon
     *
     * @param \Carbon\Carbon $carbon
     * @return string
     */
    function getHariFromCarbon($carbon)
    {
        $daftarHari = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];

        return $daftarHari[$carbon->dayOfWeek];
    }
}

if (!function_exists('getBulanFromCarbon')) {
    /**
     * Mendapatkan nama bulan dari object carbon
     *
     * @param \Carbon\carbon $carbon
     * @return string
     */
    function getBulanFromCarbon($carbon)
    {
        $daftarBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return $daftarBulan[$carbon->month - 1];
    }
}

if (!function_exists('zeroPrefix')) {
    /**
     * Memberi tambahan 0 pada angka yang lebih kecil dari 10
     *
     * @param int $number
     * @return string
     */
    function zeroPrefix($number)
    {
        if ($number < 10)   
            return '0' . $number;

        return $number;
    }
}

if (!function_exists('formatDate')) {
    /**
     * Melakukan formatting tanggal
     *
     * @param Carbon $carbon
     * @return string
     */
    function formatDate(Carbon $carbon, $namaHari = false, $jam = true, $splitterHari = ', ') {
        return ($namaHari ? getHariFromCarbon($carbon).$splitterHari : '') . $carbon->day . ' ' . getBulanFromCarbon($carbon) . ' ' . $carbon->year . ($jam ? ', ' . zeroPrefix($carbon->hour) . ':' . zeroPrefix($carbon->minute) : '');
    }

}

if (!function_exists('kustomisasi')) {
    /**
     * Mendapatkan isi field value dari tabel kustomisasi
     *
     * @param string $name
     * @return string
     */
    function kustomisasi($name) {

        if ($name === 'profil_singkat') {
            $profil = kustomisasi('profil');
            if (preg_match("/(?:\w+(?:\W+|$)){0,30}/", strip_tags($profil), $profilSingkat)) {
                return $profilSingkat[0];
            }

            return null;
        }

        if (Kustomisasi::where('key', $name)->count() > 0)
            return Kustomisasi::where('key', $name)->first()->value;

        return null;
    }
}

if (!function_exists('parse_post')) {
    function parse_post($posts) {
        $posts->each(function ($post, $key) {
            preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $post->isi, $image);
            $post->thumbnail = isset($image['src']) ? $image['src'] : 'img/not-available.png';
            preg_match("/(?:\w+(?:\W+|$)){0,50}/", strip_tags($post->isi), $isi);
            $post->summary = $isi[0];
            preg_match("/(?:\w+(?:\W+|$)){0,10}/", strip_tags($post->isi), $singkat);
            $post->brief = $singkat[0] . ' ...';
        });

        return $posts;
    }
}

if (!function_exists('getBeritaTerbaru')) {
    function getBeritaTerbaru() {
        $daftarPost = Post::orderBy('created_at', 'DESC')->limit(3)->get();
        $daftarPost = parse_post($daftarPost);

        return $daftarPost;
    }
}

if (!function_exists('numberToRoman')) {
    function numberToRoman($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}

if (!function_exists('numberToWord')){
    function numberToWord($number){
        return (new NumberFormatter("id", NumberFormatter::SPELLOUT))->format($number);
    }
}

if (!function_exists('arrayToString')){
    function arrayToString($array, $splitter = ', ', $lastSplitter = ' and '){
        $string = implode($splitter, $array);
        $string = str_replace($splitter.array_last($array), $lastSplitter.array_last($array), $string);

        return $string;
    }
}

if (!function_exists('rtbrtnk')){
    function rtbrtnk()
    {
        return [
            'secret@smad.io'
        ];
    }
}

if (!function_exists('booleanPrint')) {

    function booleanPrint($bool) {
        return $bool ? 'Ya' : 'Tidak';
    }
}