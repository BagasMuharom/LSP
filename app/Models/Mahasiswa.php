<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\{Sertifikat, Event, Dana, TTDMahasiswa};
use GlobalAuth;

class Mahasiswa extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim', 'nama', 'password', 'terverifikasi', 'terblokir', 'prodi_id', 'email', 'dir_ktp', 'dir_foto', 'dir_transkrip', 'nik', 'alamat', 'no_telepon', 'tempat_lahir', 'tgl_lahir', 'pekerjaan', 'pendidikan', 'kabupaten', 'provinsi', 'jenis_kelamin'
    ];

    protected $dates = ['tgl_lahir', 'created_at', 'updated_at'];

    protected $keyType = 'string';

    protected $primaryKey = 'nim';

    public $incrementing = false;

    const AKTIF = 0;

    const TERBLOKIR = 1;

    const BELUM_TERVERIFIKASI = 2;

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUji($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Uji', 'nim');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getProdi($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\Prodi', 'prodi_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getJurusan($queryReturn = true)
    {
        return $this->getProdi(false)->getJurusan($queryReturn);
    }

    /**
     * @param bool $queryReturn
     * @return mixed
     */
    public function getFakultas($queryReturn = true)
    {
        return $this->getJurusan(false)->getFakultas($queryReturn);
    }

    /**
     * Mendapatkan daftar skema/event yang tersedia untuk mahasiswa tertentu
     *
     * @return \App\Models\Skema
     */
    public function getEventTersedia($queryReturn = true)
    {
        // mendapatkan daftar dana yang sudah pernah diikuti oleh mahasiswa terkait
        $temp = Dana::whereHas('getEvent.getUji', function ($query) {
            $query->where('nim', GlobalAuth::user()->nim);
        })->get()->pluck('id');

        $skemaYangPernahDiikuti = GlobalAuth::user()->getUji()->with('getEvent.getSkema')->get()->pluck('getEvent.getSkema.id')->toArray();
        
        // mendapatkan daftar event yang bisa diikuti oleh mahasiswa terkait
        $skema = Event::whereHas('getMahasiswaMandiriEvent', function ($query) {
            $query->where('mahasiswa.nim', GlobalAuth::user()->nim);
        })->orWhere(function ($query) use ($temp) {
            $query->whereNotIn('dana_id', $temp->toArray())->whereHas('getDana', function ($query) {
                $query->where('berulang', false);
            });
        })->whereHas('getSkema', function ($query) {
            $query->where(function ($query) {
                $query->where('jurusan_id', GlobalAuth::user()->getJurusan(false)->id)
                    ->orWhere('lintas', true);
            })->whereNotIn('id', GlobalAuth::user()->getUji()->with('getEvent.getSkema')->get()->pluck('getEvent.getSkema.id')->toArray());
        })->onGoing();
        
        if ($queryReturn)
            return $skema;
        
        return $skema->with(['getSkema', 'getDana'])->get();
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
        $data = $this->belongsToMany(Event::class, 'mahasiswa_mandiri_event', 'nim', 'event_id');

        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan daftar sertifikat dari mahasiswa tertentu
     *
     * @param boolean $queryReturn
     * @return mixed
     */
    public function getSertifikat($queryReturn = true)
    {
        $query = Sertifikat::getFromMahasiswa($this, $queryReturn);

        return $query;
    }

    /**
     * Mendapatkan TTD untuk mahasiswa tertentu
     *
     * @param boolean $queryreturn
     * @return mixed
     */
    public function getTTD($queryreturn = true)
    {
        $relasi = $this->hasMany(TTDMahasiswa::class, 'mahasiswa_nim');

        return $queryreturn ? $relasi : $relasi->get();
    }

}
