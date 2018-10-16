<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\Sertifikat;
use App\Models\Uji;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    
    protected $table = 'jurusan';

    public $timestamps = false;

    protected $fillable = [
        'nama', 'fakultas_id', 'key'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getFakultas($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Fakultas', 'fakultas_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getProdi($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Prodi', 'jurusan_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getMahasiswa($queryReturn = true)
    {
        $data = $this->getProdi()->select('id')->get()->pluck('id')->toArray();
        $data = Mahasiswa::whereIn('prodi_id', $data);
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getUji($queryReturn = true)
    {
        $data = $this->getMahasiswa()->select('nim')->get()->pluck('nim')->toArray();
        $data = Uji::whereIn('nim', $data);
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getSertifikat($queryReturn = true)
    {
        $data = $this->getUji()->select('id')->get()->pluck('id')->toArray();
        $data = Sertifikat::whereIn('uji_id', $data);
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan tempat uji dari jurusan tertentu
     *
     * @param boolean $queryReturn
     * @return mixed
     */
    public function getTempatUji($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\TempatUji', 'jurusan_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param $key
     * @param $nama
     * @return bool
     */
    public static function check($key, $nama)
    {
        return Jurusan::where('key', $key)->orWhere('nama', $nama)->count() > 0;
    }

    /**
     * @param $key
     * @param $nama
     * @return mixed
     */
    public static function findByKeyOrName($key, $nama)
    {
        return Jurusan::where('key', $key)->orWhere('nama', $nama)->first();
    }
}
