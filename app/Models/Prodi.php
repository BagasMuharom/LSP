<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    
    protected $table = 'prodi';

    protected $fillable = [
        'nama', 'jurusan_id', 'key'
    ];

    public $timestamps = false;

    /**
     * @param $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getJurusan($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Jurusan', 'jurusan_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getFakultas($queryReturn = true)
    {
        return $this->getJurusan(false)->getFakultas($queryReturn);
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getMahasiswa($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Mahasiswa', 'prodi_id');
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
     * @param $key
     * @param $nama
     * @return bool
     */
    public static function check($key, $nama)
    {
        return Prodi::where('key', $key)->orWhere('nama', $nama)->count() > 0;
    }

    /**
     * @param $key
     * @param $nama
     * @return mixed
     */
    public static function findByKeyOrName($key, $nama)
    {
        return Prodi::where('key', $key)->orWhere('nama', $nama)->first();
    }
}
