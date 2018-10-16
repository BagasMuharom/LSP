<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $table = 'kuesioner';

    protected $fillable = [
        'sertifikat_id',
        'kegiatan_setelah_mendapatkan_sertifikasi',
        'nama_perusahaan',
        'alamat_perusahaan',
        'jenis_perusahaan',
        'tahun_memulai_kerja',
        'relevansi_sertifikasi_kompetensi_bidang_dengan_pekerjaan',
        'manfaat_sertifikasi_kompetensi',
        'saran_perbaikan_untuk_lsp_unesa',
        'created_at',
        'updated_at'
    ];

    /**
     * mendapatkan data sertifikat
     *
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getSertifikat($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Sertifikat', 'sertifikat_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * mendapatkan data skema
     *
     * @param bool $queryReturn
     * @return mixed
     */
    public function getSkema($queryReturn = true)
    {
        return $this->getSertifikat(false)->getSkema($queryReturn);
    }

    /**
     * mendapatkan data mahasiswa
     *
     * @param bool $queryReturn
     * @return mixed
     */
    public function getMahasiswa($queryReturn = true)
    {
        return $this->getSertifikat(false)->getMahasiswa($queryReturn);
    }
}
