<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';

    public $timestamps = false;

    protected $fillable = [
        'galeri_id', 'dir'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getGaleri($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Galeri', 'galeri_id');
        return $queryReturn ? $data : $data->first();
    }
}
