<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kustomisasi extends Model
{
    const NAMA = 'nama';

    const LOGO = 'logo';

    const PROFIL = 'profil';

    const VISI = 'visi';

    const MISI = 'misi';

    const SASARAN_MUTU = 'sasaran_mutu';

    const SUSUNAN_ORGANISASI = 'susunan_organisasi';

    const EMAIL = 'email';

    const NO_TELP = 'no_telp';

    const ALAMAT = 'alamat';

    const NO_LISENSI = 'no_lisensi';

    const PENGUMUMAN = 'pengumuman';

    const ALL = [
        self::NAMA,
        self::LOGO,
        self::PROFIL,
        self::VISI,
        self::MISI,
        self::SASARAN_MUTU,
        self::SUSUNAN_ORGANISASI,
        self::EMAIL,
        self::NO_TELP,
        self::ALAMAT,
        self::NO_LISENSI,
        self::PENGUMUMAN
    ];

    protected $table = 'kustomisasi';

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = [
        'key', 'value', 'created_at', 'updated_at', 'user_id'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getUser($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\User', 'user_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * cek apakah mempunyai user atau tidak
     * @return bool
     */
    public function hasUser()
    {
        return !empty($this->getUser(false));
    }
}