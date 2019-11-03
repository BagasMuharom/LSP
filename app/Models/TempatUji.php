<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatUji extends Model
{
    protected $table = 'tempat_uji';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'jurusan_id', 'user_id'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUji($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Uji', 'uji_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan jurusan dari tempat uji tertentu
     *
     * @param boolean $queryReturn
     * @return mixed
     */
    public function getJurusan($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\jurusan', 'jurusan_id');

        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getSkema($queryReturn = false)
    {
        $data = $this->hasMany('App\Models\Skema', 'tempat_uji_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * cek dengan kode
     *
     * @param $kode
     * @return bool
     */
    public static function check($kode)
    {
        $kode = strtoupper($kode);
        return TempatUji::where('kode', $kode)->count() > 0;
    }

    /**
     * @param $kode
     * @return mixed
     */
    public static function findByKode($kode)
    {
        $kode = strtoupper($kode);
        return TempatUji::where('kode', $kode)->first();
    }

    /**
     * @param bool $query
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|object|null
     */
    public function getUser($query = true)
    {
        $data = $this->belongsTo(User::class, 'user_id');

        return $query ? $data : $data->first();
    }
}
