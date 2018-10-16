<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'uji_id', 'nomor_sertifikat', 'created_at', 'updated_at', 'nama_pemegang', 'skema_id', 'no_urut_cetak', 'no_urut_skema', 'tanggal_cetak', 'issue_date', 'expire_date', 'tahun', 'tahun_cetak', 'nomor_registrasi'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getUji($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Uji', 'uji_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * Mendapatkan skema dari sertifikat tertentu
     *
     * @param boolean $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getSkema($queryReturn = true)
    {
        $skema = $this->belongsTo(Skema::class, 'skema_id')->withTrashed();
        return $queryReturn ? $skema : $skema->first();
    }

    /**
     * Mendapatkan kuesioner
     *
     * @param boolean $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOne|null|object
     */
    public function getKuesioner($queryReturn = true)
    {
        $kuesioner = $this->hasOne(Kuesioner::class, 'sertifikat_id');

        return $queryReturn ? $kuesioner : $kuesioner->first();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getMahasiswa($queryReturn = true)
    {
        return $this->getUji(false)->getMahasiswa($queryReturn);
    }

    /**
     * Mengecek apakah sertifikat terkait telah mengisi kuesioner
     *
     * @return boolean
     */
    public function hasKuesioner()
    {
        return $this->getKuesioner()->count() > 0;
    }

    /**
     * Mendapatkan daftar sertifikat dari mahasiswa tertentu
     *
     * @param \App\Models\Mahasiswa|\Illuminate\Database\Eloquent\Builder  $mahasiswa
     * @param boolean $queryReturn
     * @return mixed
     */
    public function scopeGetFromMahasiswa($query, $mahasiswa, $queryReturn = true)
    {
        $sertifikat = $query->whereHas('getUji', function ($query) use ($mahasiswa) {
            $query->whereHas('getMahasiswa', function ($query) use ($mahasiswa) {
                $query->where('nim', $mahasiswa->nim);
            });        
        });

        return ($queryReturn ? $sertifikat : $sertifikat->get());
    }

}
