<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis';

    public $timestamps = false;

    protected $fillable = [
        'nama'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getSkema($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Skema', 'jenis_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param $nama
     * @return bool
     */
    public static function check($nama)
    {
        return Jenis::where('nama', 'ILIKE', "%{$nama}%")->count() > 0;
    }

    /**
     * @param $nama
     * @return mixed
     */
    public static function findLike($nama)
    {
        return Jenis::where('nama', 'ILIKE', "%{$nama}%")->first();
    }
}
