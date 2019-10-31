<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['unit_kompetensi_id',
        'pertanyaan'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * unitKompetensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unitKompetensi()
    {
        return $this->belongsTo(UnitKompetensi::class, 'unit_kompetensi_id');
    }


}