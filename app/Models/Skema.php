<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skema extends Model
{
    use SoftDeletes;

    protected $table = 'skema';

    public $timestamps = false;

    protected $fillable = [
        'jurusan_id', 'kode', 'nama', 'keterangan', 'sektor', 'jenis_id', 'lintas', 'harga', 'kbli', 'kbji', 'level_kkni', 'kode_unit_skkni', 'kualifikasi', 'qualification'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getJurusan($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Jurusan', 'jurusan_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getJenis($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Jenis', 'jenis_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getSkemaUnit($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\UnitKompetensi', 'skema_unit', 'skema_id', 'unit_kompetensi_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getElemenKompetensi($queryReturn = true)
    {
        $data = $this->getSkemaUnit()->select('id')->get()->pluck('id')->toArray();
        $data = ElemenKompetensi::whereIn('unit_kompetensi_id', $data);
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getAsesorSkema($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\User', 'asesor_skema', 'skema_id', 'user_id');
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getSyarat($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Syarat', 'skema_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan daftar uji sesuai skema tertentu
     *
     * @param boolean $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUji($queryReturn = true)
    {
        $daftaruji = $this->hasMany('App\Models\Uji', 'skema_id');
        return $queryReturn ? $daftaruji : $daftaruji->get();
    }

    public function getTempatUji($queryReturn = true)
    {
        $tuk = $this->belongsTo('App\Models\TempatUji', 'tempat_uji_id');

        return $queryReturn ? $tuk : $tuk->first();
    }

    public function hasTempatUji()
    {
        return !empty($this->getTempatUji(false));
    }

    public function hasJenis()
    {
        return !empty($this->getJenis(false));
    }

    public static function isAvailable($kode)
    {
        return (Skema::where('kode', $kode)->count() > 0);
    }

    public static function findByKode($kode)
    {
        return Skema::where('kode', $kode)->first();
    }
}
