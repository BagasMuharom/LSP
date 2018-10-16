<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kriteria extends Model
{
    use SoftDeletes;

    protected $table = 'kriteria';

    public $timestamps = false;

    protected $fillable = [
        'elemen_kompetensi_id', 'unjuk_kerja', 'pertanyaan'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getElemenKompetensi($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\ElemenKompetensi', 'elemen_kompetensi_id')->withTrashed();
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPenilaian($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Uji', 'penilaian', 'kriteria_id', 'uji_id')->withPivot('nilai');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPenilaianDiri($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Uji', 'penilaian_diri', 'kriteria_id', 'uji_id')->withPivot('nilai');
        return $queryReturn ? $data : $data->get();
    }

    public function scopeAfterFirst($query, $queryReturn = true)
    {
        $query->offset(1);

        return $queryReturn ? $query : $query->get();
    }

}
