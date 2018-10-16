<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    
    protected $table = 'fakultas';

    protected $fillable = [
        'nama', 'key'
    ];

    public $timestamps = false;

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getJurusan($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Jurusan', 'fakultas_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getProdi($queryReturn = true)
    {
        $data = $this->getJurusan()->select('id')->get()->pluck('id')->toArray();
        $data = Prodi::whereIn('jurusan_id', $data);
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
        $data = $this->getMahasiswa()->select('nim')->get()->pluck('id')->toArray();
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
     * @param $key
     * @param $nama
     * @return bool
     */
    public static function check($key, $nama)
    {
        return Fakultas::where('key', $key)->orWhere('nama', $nama)->count() > 0;
    }

    /**
     * @param $key
     * @param $nama
     * @return mixed
     */
    public static function findByKeyOrName($key, $nama)
    {
        return Fakultas::where('key', $key)->orWhere('nama', $nama)->first();
    }
}