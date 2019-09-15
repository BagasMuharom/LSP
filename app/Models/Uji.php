<?php

namespace App\Models;

use App\Support\EncryptedModel;
use App\Support\Penilaian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Uji extends Model
{

    use EncryptedModel;

    protected $table = 'uji';

    protected $fillable = [
        'nim',
        'event_id',
        'admin_id',
        'bag_sertifikasi_id',
        'terverifikasi_admin',
        'terverifikasi_bag_sertifikasi',
        'catatan',
        'created_at',
        'updated_at',
        'umpan_balik',
        'identifikasi_kesenjangan',
        'saran_tindak_lanjut',
        'rekomendasi_asesor',
        'rekomendasi_asesor_asesmen_diri',
        'catatan_asesmen_diri',
        'tanggal_uji',
        'tidak_melanjutkan_asesmen',
        'konfirmasi_penilaian_asesor',
        'konfirmasi_asesmen_diri',
        'helper',
        'lulus',
        'proses_asesmen'
    ];

    protected $casts = [
        'helper' => 'array'
    ];

    const BELUM_DIVERIFIKASI = 1;

    const TERVERIFIKASI_ADMIN = 2;

    const DITOLAK_ADMIN = 3;

    const TERVERIFIKASI_BAG_SERTIFIKASI = 4;

    const BELUM_DIVERIFIKASI_ADMIN = 15;

    const BELUM_DIVERIFIKASI_BAG_SERTIFIKASI = 16;

    const DITOLAK_BAG_SERTIFIKASI = 5;

    const BELUM_MEMILIKI_TUK = 6;

    const BELUM_MEMILIKI_TANGGAL_UJI = 14;

    const MENGISI_ASESMEN_DIRI = 12;

    const BELUM_MEMILIKI_ASESOR = 7;
    
    const LULUS_ASESMEN_DIRI = 18;

    const TIDAK_LULUS_ASESMEN_DIRI = 19;

    const BELUM_DINILAI = 8;

    const PROSES_PENILAIAN = 13;

    const LULUS = 9;

    const TIDAK_LULUS = 10;

    const MEMILIKI_SERTIFIKAT = 11;

    const TIDAK_LANJUT_ASESMEN = 17;

    /**
     * Mendapatkan admin/user yang memverifikasi uji terkait
     *
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getAdmin($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Users', 'admin_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * Mendapatkan user/bagian sertifikasi yang memverifikasi uji terkait
     *
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getBagSertifikasi($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Users', 'bag_sertifikasi_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * Mendapatkan daftar asesor dari uji tertentu
     *
     * @param boolean $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsToMany|null|object
     */
    public function getAsesorUji($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\User', 'asesor_uji', 'uji_id', 'user_id')->withPivot('ttd');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan tempat uji
     *
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getTempatUji($queryReturn = true)
    {
        return $this->getSkema(false)->gettempatUji($queryReturn);
    }

    /**
     * Mendapatkan Event
     *
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getEvent($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Event', 'event_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * Mendapatkan skema
     *
     * @param bool $queryReturn
     * @return mixed
     */
    public function getSkema($queryReturn = true)
    {
        return $this->getEvent(false)->getSkema($queryReturn);
    }

    /**
     * Mendapatkan mahasiswa
     *
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getMahasiswa($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Mahasiswa', 'nim');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * mendapatkan sertifikat
     *
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasOne|null|object
     */
    public function getSertifikat($queryReturn = true)
    {
        $data = $this->hasOne('App\Models\Sertifikat', 'uji_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryreturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getSyaratUji($queryreturn = true)
    {
        $data = $this->belongsToMany('App\Models\Syarat', 'syarat_uji', 'uji_id', 'syarat_id')->withPivot('filename');
        return $queryreturn ? $data : $data->get();
    }

    /**
     * Mengecek apakah uji tertentu memiliki asesor
     *
     * @return boolean
     */
    public function hasAsesor()
    {
        return $this->getAsesorUji()->count() > 0;
    }

    /**
     * Mengecek apakah mahasiswa terkait telah mengisi penilaian diri
     *
     * @return boolean
     */
    public function hasPenilaianDiri()
    {
        return $this->getPenilaianDiri()->count() > 0 && $this->getPenilaianDiri()->wherePivot('nilai', null)->count() === 0;
    }

    /**
     * Mengecek apakah mahasisw aerkait memiliki penilaian
     *
     * @return boolean
     */
    public function hasPenilaian()
    {
        return $this->getPenilaian()->count() > 0 && $this->getPenilaian()->wherePivot('nilai', null)->count() === 0;
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPenilaian($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Kriteria', 'penilaian', 'uji_id', 'kriteria_id')->withPivot(['nilai', 'bukti'])->withTrashed();
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getUnitYangBelumKompeten($queryReturn = true)
    {
        $data = $this->getSkema(false)
            ->getSkemaUnit()
            ->whereHas('getElemenKompetensi.getKriteria.getPenilaian', function ($query) {
                $query->where('id', $this->id)
                    ->whereIn('nilai', [
                        Penilaian::BELUM_KOMPETEN,
                        Penilaian::ASESMEN_LANJUT
                    ]);
            });

        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan unit yang kompeten berdasarkan hasil penilaian
     *
     * @param boolean $queryReturn
     * @return mixed
     */
    public function getUnitYangKompeten($queryReturn = true)
    {
        $data = $this->getSkema(false)
            ->getSkemaUnit()
            ->whereNotIn('id', $this->getUnitYangBelumKompeten(false)->pluck('id')->toArray());

        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan unit yang belum lulus (dilihat dari method getUnitYangBelumKompeten dan
     * isi dari nilaiUnit di kolom helper)
     *
     * @return mixed
     */
    public function getUnitYangBelumLulus()
    {
        $daftarUnit = collect([]);

        $daftarUnit = $daftarUnit->merge($this->getUnitYangBelumKompeten(false));

        $daftarBukti = collect($this->helper['nilai_unit']);
        foreach ($this->getUnitYangKompeten(false) as $unit) {
            if ($daftarBukti->has($unit->id)) {
                $bkPertama = collect($daftarBukti[$unit->id])->filter(function ($value, $key) {
                    return $value == 'BK';
                });

                if ($bkPertama->count() > 0)
                    $daftarUnit->push($unit);
            }
        }

        return $daftarUnit;
    }

    /**
     * @param UnitKompetensi $unit
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Collection[]|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasMany[]|mixed
     */
    public function getElemenYangBelumKompeten(UnitKompetensi $unit, $queryReturn = true)
    {
        $data = $unit->getElemenKompetensi()
            ->whereHas('getKriteria', function ($query) {
                $query->whereIn('id', function ($query) {
                    $query->select('kriteria_id')
                        ->from('penilaian')
                        ->where('uji_id', $this->id)
                        ->whereIn('nilai', [
                            Penilaian::BELUM_KOMPETEN,
                            Penilaian::ASESMEN_LANJUT
                        ]);
                });
            });

        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param ElemenKompetensi $elemen
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany|mixed
     */
    public function getKriteriaYangBelumKompeten(ElemenKompetensi $elemen, $queryReturn = true)
    {
        $data = $this->getPenilaian()->whereIn('nilai', [
            Penilaian::BELUM_KOMPETEN,
            Penilaian::ASESMEN_LANJUT
        ])->where('elemen_kompetensi_id', $elemen->id);

        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPenilaianDiri($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Kriteria', 'penilaian_diri', 'uji_id', 'kriteria_id')->withPivot('nilai', 'bukti', 'v', 'a', 't', 'm')->withTrashed();
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mengecek apakah uji tertentu telah memiliki sertifikat
     *
     * @return boolean
     */
    public function hasSertifikat()
    {
        return !is_null($this->getSertifikat(false));
    }

    /**
     * Mengecek apakah uji tertentu dinyatakan lulus
     *
     * @return boolean
     */
    public function isLulus()
    {
        return $this->getUnitYangBelumKompeten()->count() == 0 && $this->konfirmasi_penilaian_asesor;
    }

    /**
     * Mengecek apakah uji tertentu dinyatakan tidak lulus
     *
     * @return boolean
     */
    public function isTidakLulus()
    {
        return $this->getUnitYangBelumKompeten()->count() > 0 && $this->konfirmasi_penilaian_asesor;
    }

    /**
     * Mengecek apakah uji tertentu ditolak
     *
     * @return boolean
     */
    public function isDitolak()
    {
        if (is_null($this->terverifikasi_admin) && is_null($this->terverifikasi_bag_sertifikasi)) {
            return false;
        }

        return $this->terverifikasi_admin === false || $this->terverifikasi_bag_sertifikasi === false;
    }

    /**
     * Mengecek apakah uji terkait sedang dalam proses penilaian
     *
     * @return boolean
     */
    public function isDalamProsesPenilaian()
    {
        return $this->getPenilaian()->where(function ($query) {
            $query->whereNotNull('nilai')->orWhereNotNull('bukti');
        })->count() > 0 && $this->konfirmasi_penilaian_asesor === false;
    }

    /**
     * Mengecek apakah penilaian dari uji terkait telah lengkap
     *
     * @return boolean
     */
    public function isPenilaianLengkap()
    {
        return ($this->getPenilaian()->whereNull('nilai')->orWhereNull('bukti')->count() == 0 && !is_null($this->umpan_balik) && !is_null($this->identifikasi_kesenjangan) && !is_null($this->saran_tindak_lanjut) && !is_null($this->rekomendasi_asesor));
    }

    /**
     * Mengecek apakah penilaian diri dari uji terkait telah lengkap dan sudah dikonfirmasi
     * oleh asesor
     *
     * @return boolean
     */
    public function isPenilaianDiriLengkap()
    {
        return ($this->getPenilaianDiri()->whereNull('nilai')->count() == 0 && !is_null($this->rekomendasi_asesor_asesmen_diri) && !is_null($this->catatan_asesmen_diri) && $this->konfirmasi_asesmen_diri);
    }

    /**
     * Mengecek apakah uji terkait lulus penilaian diri
     *
     * @return boolean
     */ 
    public function isLulusPenilaianDiri()
    {
        $jumlahBelumKompeten = $this->getPenilaianDiri()
                                    ->where('nilai', Penilaian::BELUM_KOMPETEN)
                                    ->count();
        $jumlahVATMKosong = $this->getPenilaianDiri()
                                ->whereNull('v')
                                ->whereNull('a')
                                ->whereNull('t')
                                ->whereNull('m')
                                ->count();
        
        return ($jumlahBelumKompeten == 0 && $jumlahVATMKosong == 0 && $this->konfirmasi_asesmen_diri);
    }
    
    /**
     * Mengecek apakah uji terkait tidak lulus penilaian diri
     *
     * @return boolean
     */ 
    public function isTidakLulusPenilaianDiri()
    {
        $jumlahBelumKompeten = $this->getPenilaianDiri()
                                    ->where('nilai', Penilaian::BELUM_KOMPETEN)
                                    ->count();
        $jumlahVATMKosong = $this->getPenilaianDiri()
                                ->whereNull('v')
                                ->whereNull('a')
                                ->whereNull('t')
                                ->whereNull('m')
                                ->count();

        return ($jumlahBelumKompeten > 0) || ($jumlahVATMKosong > 0 && $this->konfirmasi_asesmen_diri);
    }
    
    /**
     * Mendapatkan status dari uji tertentu
     *
     * @return array
     */
    public function getStatus()
    {
        $color = '';
        $status = '';
        $code = '';
        if ($this->tidak_melanjutkan_asesmen) {
            $color = 'danger';
            $status = 'Tidak melanjutkan asesmen';
            $code = static::TIDAK_LANJUT_ASESMEN;
        } else if ($this->hasSertifikat()) {
            $color = 'success';
            $status = 'Sertifikat telah diterbitkan';
            $code = static::MEMILIKI_SERTIFIKAT;
        } else if ($this->isLulus()) {
            $color = 'success';
            $status = 'Lulus sertifikasi';
            $code = static::LULUS;
        } else if ($this->isTidakLulus()) {
            $color = 'danger';
            $status = 'Tidak Lulus sertifikasi';
            $code = static::TIDAK_LULUS;
        } else if (is_null($this->terverifikasi_admin)) {
            $color = 'secondary';
            $status = 'Belum Diverifikasi Admin';
            $code = static::BELUM_DIVERIFIKASI_ADMIN;
        } else if ($this->isDalamProsesPenilaian()) {
            $color = 'warning';
            $status = 'Dalam Proses Penilaian';
            $code = static::PROSES_PENILAIAN;
        } else if ($this->hasPenilaianDiri()) {
                
            if ($this->isLulusPenilaianDiri()) {
                $color = 'primary';
                $status = 'Lulus asesmen diri';
                $code = static::LULUS_ASESMEN_DIRI;
            } else if ($this->isTidakLulusPenilaianDiri()){
                $color = 'danger';
                $status = 'Tidak lulus asesmen diri';
                $code = static::TIDAK_LULUS_ASESMEN_DIRI;
            } else {
                $color = 'primary';
                $status = 'Telah mengisi asesmen diri';
                $code = static::MENGISI_ASESMEN_DIRI;
            }

        } else if (!is_null($this->terverifikasi_bag_sertifikasi)) {
            $color = 'primary';
            $status = 'Terverifikasi Bag. Sertifikasi';
            $code = static::TERVERIFIKASI_BAG_SERTIFIKASI;

            if (!$this->terverifikasi_bag_sertifikasi) {
                $color = 'danger';
                $status = 'Ditolak Bag. Sertifikasi';
                $code = static::DITOLAK_BAG_SERTIFIKASI;
            }

        } else if (is_null($this->terverifikasi_bag_sertifikasi)) {
            $color = 'secondary';
            $status = 'Belum Diverifikasi Bag. Sertifikasi';
            $code = static::BELUM_DIVERIFIKASI_BAG_SERTIFIKASI;

            if (!$this->terverifikasi_admin) {
                $color = 'danger';
                $status = 'Ditolak admin';
                $code = static::DITOLAK_ADMIN;
            }

        } else if (!$this->hasAsesor()) {
            $color = 'primary';
            $status = 'Belum memiliki asesor';
            $code = static::BELUM_MEMILIKI_ASESOR;
        }

        return [
            'color' => $color,
            'status' => $status,
            'code' => $code,
        ];
    }

    /**
     * Inisialisasi penilaian diri dengan menambah record baru pada tabel penilaian_diri
     * dengan nilai = null
     *
     * @return void
     */
    public function initPenilaianDiri()
    {
        $skema = $this->getSkema(false);
        $daftarKriteria = $skema->getKriteria();

        foreach ($daftarKriteria->get() as $kriteria) {
            $this->getPenilaianDiri()->attach($kriteria->id);
        }
    }

    /**
     * Inisialisasi penilaian dengan nilai = null dan bukti = null
     *
     * @return void
     */
    public function initPenilaian()
    {
        $skema = $this->getSkema(false);
        $daftarKriteria = $skema->getKriteria();

        $nilaiUnit = [];

        foreach ($skema->getSkemaUnit(false) as $item) {
            $nilaiUnit[$item->id] = [
                'Tes Lisan' => null,
                'Tes Tertulis' => null,
                'Wawancara' => null,
                'Verifikasi Pihak Ketiga' => null,
                'Studi Kasus' => null
            ];
        }

        $json = $this->helper;
        $json['nilai_unit'] = $nilaiUnit;

        $this->update([
            'helper' => $json
        ]);

        foreach ($daftarKriteria->get() as $kriteria) {
            $this->getPenilaian()->attach($kriteria->id);
        }
    }

    /**
     * Melakukan filter berdasarkan status
     *
     * @param Uji $query
     * @param int $status
     * @return Uji
     */
    public function scopeFilterByStatus($query, $status)
    {
        switch ($status) {
            case static::TERVERIFIKASI_ADMIN:
                return $query->where('terverifikasi_admin', true)->whereNull('terverifikasi_bag_sertifikasi');
                break;
            case static::DITOLAK_ADMIN:
                return $query->where('terverifikasi_admin', false);
                break;
            case static::TERVERIFIKASI_BAG_SERTIFIKASI:
                return $query->where('terverifikasi_bag_sertifikasi', true)->doesntHave('getPenilaian');
                break;
            case static::DITOLAK_BAG_SERTIFIKASI:
                return $query->where('terverifikasi_bag_sertifikasi', false);
                break;
            case static::BELUM_DIVERIFIKASI:
                return $query->whereNull('terverifikasi_admin')
                    ->orWhereNull('terverifikasi_bag_sertifikasi')
                    ->where('terverifikasi', '!=', false);
                break;
            case static::BELUM_DIVERIFIKASI_ADMIN:
                return $query->whereNull('terverifikasi_admin');
                break;
            case static::BELUM_DIVERIFIKASI_BAG_SERTIFIKASI:
                return $query->whereNull('terverifikasi_bag_sertifikasi');
                break;
            case static::MENGISI_ASESMEN_DIRI:
                return $query->whereHas('getPenilaianDiri', function ($query) {
                    $query->whereNotNull('nilai');
                })->whereDoesntHave('getPenilaianDiri', function ($query) {
                    $query->where('nilai', Penilaian::BELUM_KOMPETEN);
                })
                // ->whereDoesntHave('getPenilaian')
                ->where('konfirmasi_asesmen_diri', false);
                break;
            case static::BELUM_MEMILIKI_ASESOR:
                return $query->filterByStatus(Uji::MENGISI_ASESMEN_DIRI)->doesntHave('getAsesorUji');
                break;
            case static::BELUM_DINILAI:
                return $query->whereHas('getPenilaianDiri', function ($query) {
                    $query->whereNotNull('nilai');
                })->whereDoesntHave('getPenilaian', function ($query) {
                    $query->whereNotNull('nilai');
                })->whereHas('getAsesorUji');
                break;
            case static::TIDAK_LULUS:
                return $query->where('lulus', false);
                break;
            case static::LULUS:
                return $query->where('lulus', true);
                break;
            case static::MEMILIKI_SERTIFIKAT:
                return $query->whereHas('getSertifikat');
                break;
            case static::BELUM_MEMILIKI_TANGGAL_UJI:
                return $query->whereNull('tanggal_uji');
                break;
            case static::PROSES_PENILAIAN:
                return $query->whereHas('getPenilaian', function ($query) {
                    $query->whereNotNull('nilai')->orWhereNotNull('bukti');
                })->where('konfirmasi_penilaian_asesor', false);
                break;
            case static::TIDAK_LANJUT_ASESMEN:
                return $query->where('tidak_melanjutkan_asesmen', true);
                break;
            case static::LULUS_ASESMEN_DIRI:
                return $query->where('konfirmasi_asesmen_diri', true)->whereDoesntHave('getPenilaianDiri', function ($query) {
                    $query->where('nilai', Penilaian::BELUM_KOMPETEN)->orWhere(function ($query) {
                        $query->whereNull('v')
                            ->whereNull('a')
                            ->whereNull('t')
                            ->whereNull('m');
                    });
                })->whereDoesntHave('getPenilaian', function ($query) {
                    $query->whereNotNull('nilai')->orWhereNotNull('bukti');
                });
                break;
            case static::TIDAK_LULUS_ASESMEN_DIRI:
                return $query->whereHas('getPenilaianDiri', function ($query) {
                    $query->where('nilai', Penilaian::BELUM_KOMPETEN)->orWhere(function ($query) {
                        $query->whereNull('v')
                            ->whereNull('a')
                            ->whereNull('t')
                            ->whereNull('m');
                    });
                });
                break;
        }
    }

    /**
     * Mendapatkan daftar uji yang masih dalam proses pendaftaran
     *
     * @param Uji $query
     * @return Uji
     */
    public function scopeGetPendaftaran($query)
    {
        return $query->whereDoesntHave('getPenilaianDiri', function ($query) {
            $query->whereNotNull('nilai');
        });
    }

    /**
     * Mendapatkan daftar uji yang lolos verifikasi
     *
     * @param mixed $query
     * @return mixed
     */
    public function scopeGetLolosVerifikasi($query)
    {
        return $query->has('getPenilaianDiri');
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->hasPenilaian() & $this->getPenilaian()->where(function ($query) {
            $query->where('nilai', null);
        })->count() == 0;
    }

    /**
     * Mereset penilaian
     *
     * @return void
     */
    public function resetPenilaian()
    {
        $this->getPenilaian()->newPivotStatement()
        ->where('uji_id', $this->id)->update([
                'nilai' => null,
                'bukti' => null,
            ]);
    }

    /**
     * Mereset penilaian diri
     *
     * @return void
     */
    public function resetPenilaianDiri()
    {
        $this->getPenilaianDiri()->newPivotStatement()
        ->where('uji_id', $this->id)->update([
                'nilai' => null,
                'bukti' => null,
                'v' => null,
                'a' => null,
                't' => null,
                'm' => null,
            ]);

        $this->konfirmasi_asesmen_diri = false;
        $this->save();
    }

    /**
     * Mendapatkan daftar nama asesor dalam bentuk string
     *
     * @return void
     */
    public function getAsesorAttribute()
    {
        return implode(', ', $this->getAsesorUji(false)->pluck('nama')->toArray());
    }

    /**
     * Mendapatkan daftar bukti pada unit tertentu
     * Daftar bukti bisa dilihat di kolom helper pada key nilai_unit
     *
     * @param App\Models\UnitKomepetensi $unit
     * @return array
     */
    public function getBuktiUnitTertentu(UnitKompetensi $unit)
    {
        return collect($this->helper['nilai_unit'][$unit->id])->filter(function ($value, $key) {
            return !is_null($value);
        });
    }

    /**
     * Mendapatkan daftar bukti komptensi yang diunggah oleh asesi
     *
     * @return mixed
     */
    public function getBuktiKompetensi()
    {
        $files = collect([]);
        $daftar = Storage::files('public/bukti_kompetensi/' . $this->id);

        foreach ($daftar as $file) {
            $files->put(pathinfo($file, PATHINFO_BASENAME), pathinfo($file, PATHINFO_FILENAME));
        }

        return $files;
    }

    /**
     * Mendapatkan daftar portofolio yang diunggah asesi
     *
     * @return mixed
     */
    public function getPortofolio()
    {
        $files = collect([]);
        $daftar = Storage::files('public/portofolio/' . $this->id);

        foreach ($daftar as $file) {
            $files->put(pathinfo($file, PATHINFO_BASENAME), pathinfo($file, PATHINFO_FILENAME));
        }

        return $files;
    }

    /**
     * Mengecek apakah helper memiliki key tertentu
     * 
     * @return boolean
     */
    public function isHelperHasKey($key)
    {
        return collect($this->helper)->has($key);
    }

    /**
     * Mendapatkan isian untuk form FR AI 02
     *
     * @return mixed
     */
    public function getIsianFRAI02()
    {
        // Jika pada helper tidak terdapat key 'frai02'
        // maka dikembalikan array kosong 
        if (!isset($this->helper['frai02'])) {
            return collect([
                'hasil' => collect([]),
                'umum' => [
                    'pengetahuan_kandidat' => null
                ]
            ]);
        }

        $frai02 = $this->helper['frai02'];
        $frai02_hasil = collect($this->helper['frai02']['hasil']);

        $frai02_hasil = $frai02_hasil->map(function ($item) {
            $item['unit'] = UnitKompetensi::find($item['unit']);

            return collect($item);
        });

        $frai02['hasil'] = collect($frai02_hasil);

        return collect($frai02);
    }

}
