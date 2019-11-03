<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElemenKompetensi extends Model
{
    use SoftDeletes;

    protected $table = 'elemen_kompetensi';

    public $timestamps = false;

    protected $fillable = [
        'unit_kompetensi_id', 'nama', 'benchmark'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getUnitKompetensi($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\UnitKompetensi', 'unit_kompetensi_id')->withTrashed();
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getKriteria($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Kriteria', 'elemen_kompetensi_id');
        return $queryReturn ? $data : $data->get();
    }
}
