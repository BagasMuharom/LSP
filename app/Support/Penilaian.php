<?php
/**
 * Created by PhpStorm.
 * User: rafya
 * Date: 12/07/2018
 * Time: 12:26
 */

namespace App\Support;


class Penilaian
{
    const KOMPETEN = 'K';

    const BELUM_KOMPETEN = 'BK';

    const ASESMEN_LANJUT = 'AL';

    const BUKTI_LANGSUNG = 'BL';

    const BUKTI_TIDAK_LANGSUNG = 'BTL';

    const BUKTI_TAMBAHAN = 'BT';

    const ALL = [
        self::KOMPETEN,
        self::BELUM_KOMPETEN,
        self::ASESMEN_LANJUT
    ];

    const DIRI = [
        self::KOMPETEN,
        self::BELUM_KOMPETEN
    ];

    const ARRAY = [
        0 => self::KOMPETEN,
        1 => self::BELUM_KOMPETEN,
        2 => self::ASESMEN_LANJUT
    ];
}