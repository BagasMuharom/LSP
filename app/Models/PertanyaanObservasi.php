<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $unit_kompetensi_id unit kompetensi id
 * @property text $pertanyaan pertanyaan
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property timestamp $deleted_at deleted at
 * @property UnitKompetensi $unitKompetensi belongsTo
 */
class PertanyaanObservasi extends Model
{

    /**
     * Database table name
     */
    protected $table = 'pertanyaan_observasi';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['unit_kompetensi_id', 'pertanyaan'];

    /**
     * Date time columns.
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    use SoftDeletes;

    /**
     * unitKompetensi
     *
     * @param boolean $queryReturn
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unitKompetensi($queryReturn = true)
    {
        $query = $this->belongsTo(UnitKompetensi::class, 'unit_kompetensi_id');

        return $queryReturn ? $query : $query->get();
    }

    /**
     * Mendapatkan jawaban pertanyaan berdasarkan uji tertentu
     *
     * @param boolean $queryReturn
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getJawabanObservasi($queryReturn = true)
    {
        $query = $this->belongsToMany(
                    Uji::class, 
                    'jawaban_pertanyaan_observasi', 
                    'pertanyaan_observasi_id', 
                    'uji_id')->withPivot([
                        'jawaban', 'memuaskan'
                    ]);
        
        return $queryReturn ? $query : $query->get();
    }

}