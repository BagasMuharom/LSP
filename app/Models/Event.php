<?php

namespace App\Models;

use App\Support\Penilaian;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Mahasiswa, Uji};

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
        'skema_id',
        'dana_id',
        'tgl_mulai_pendaftaran',
        'tgl_akhir_pendaftaran',
        'tgl_uji',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'tgl_mulai_pendaftaran',
        'tgl_akhir_pendaftaran',
        'tgl_uji',
        'created_at',
        'updated_at'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getSkema($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Skema', 'skema_id')->withTrashed();
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getDana($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Dana', 'dana_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUji($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Uji', 'event_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan relasi pada tabel mahasiswa_mandiri_event yang menyimpan nim mahasiswa
     * dengan id event mandiri
     *
     * @param boolean $queryReturn
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getMahasiswaMandiriEvent($queryReturn = true)
    {
        $data = $this->belongsToMany(Mahasiswa::class, 'mahasiswa_mandiri_event', 'event_id', 'nim');

        return $queryReturn ? $data : $data->get();
    }
    
    /** 
     * cek apakah event telah ada
     *
     * @param Skema $skema
     * @param Dana $dana
     * @param Carbon $tglMulaiPendaftaran
     * @param Carbon $tglAkhirPendaftaran
     * @param Carbon $tglUji
     * @return bool
     */
    public static function has(Skema $skema, Dana $dana, Carbon $tglMulaiPendaftaran, Carbon $tglAkhirPendaftaran, Carbon $tglUji)
    {
        return Event::where('skema_id', $skema->id)
            ->where('dana_id', $dana->id)
            ->where('tgl_mulai_pendaftaran', $tglMulaiPendaftaran)
            ->where('tgl_akhir_pendaftaran', $tglAkhirPendaftaran)
            ->where('tgl_uji', $tglUji)
            ->count() > 0;
    }

    /**
     * Mendapatkan event yang masih dibuka pendaftarannya
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return void
     */
    public function scopeOnGoing($query)
    {
        $now = Carbon::now();

        return $query->whereDate('tgl_mulai_pendaftaran', '<=', $now)
                    ->whereDate('tgl_akhir_pendaftaran', '>=', $now);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeComingSoon($query)
    {
        return $query->where('tgl_mulai_pendaftaran', '>', Carbon::now());
    }

    /**
     * mengecek apakah event sedang berlangsung
     * 
     * @return bool
     */
    public function isOnGoing()
    {
        return Carbon::now()->between($this->tgl_mulai_pendaftaran, $this->tgl_uji);
    }

    /**
     * mengecek apakah event akan datang
     *
     * @return bool
     */
    public function isAkanDatang()
    {
        return Carbon::now()->lessThan($this->tgl_mulai_pendaftaran);
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return Carbon::now()->greaterThan($this->tgl_uji);
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getTempatUji($queryReturn = true)
    {
        return $this->getSkema(false)->getTempatUji($queryReturn);
    }
}
