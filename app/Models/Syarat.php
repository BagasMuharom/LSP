<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syarat extends Model
{
    protected $table = 'syarat';

    public $timestamps = false;

    protected $fillable = [
        'nama', 'created_at', 'updated_at', 'skema_id', 'upload'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getSyaratUji($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Uji', 'syarat_uji', 'syarat_id', 'uji_id')->withPivot('filename');
        return $queryReturn ? $data : $data->get();
    }
}
