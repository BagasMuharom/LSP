<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKompetensi extends Model
{
    use SoftDeletes;

    protected $table = 'unit_kompetensi';

    public $timestamps = false;

    protected $fillable = [
        'nama', 'kode'
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getElemenKompetensi($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\ElemenKompetensi', 'unit_kompetensi_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getKriteria($queryReturn = true)
    {
        $data = $this->getElemenKompetensi()->select('id')->get()->pluck('id')->toArray();
        $data = Kriteria::whereIn('elemen_kompetensi_id', $data);
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getSkemaUnit($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Skema', 'skema_unit', 'unit_kompetensi_id', 'skema_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param $kode
     * @return bool
     */
    public static function isAvailable($kode)
    {
        return (UnitKompetensi::where('kode', $kode)->count() > 0);
    }

    /**
     * @param $kode
     * @return bool
     */
    public static function isAvailableInTrash($kode)
    {
        return (UnitKompetensi::withTrashed()->where('kode', $kode)->count() > 0);
    }

    public function pertanyaanObservasi()
    {
        return $this->hasMany(PertanyaanObservasi::class, 'unit_kompetensi_id');
    }
}
