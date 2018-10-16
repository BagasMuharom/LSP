<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'user_id', 'nama', 'keterangan', 'created_at', 'updated_at'
    ];

    /**
     * @return mixed
     */
    public static function carousel()
    {
        return Galeri::where('nama', 'Carousel')->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getFoto($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Foto', 'galeri_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getUser($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\User', 'user_id');
        return $queryReturn ? $data : $data->first();
    }
}
