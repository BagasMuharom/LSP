<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    const VERIFIKASI = 'verifikasi'; // selesai

    const SKEMA = 'skema'; // selesai

    const UNIT = 'unit'; // selesai

    const ROLE = 'role'; // selesai

    const SERTIFIKAT = 'sertifikat'; // selesai

    const UJI = 'uji'; // selesai

    const USER = 'user'; // selesai

    const ASESOR = 'asesor'; // selesai

    const MAHASISWA = 'mahasiswa'; // selesai

    const MENU = 'menu'; // selesai

    const BLOG = 'blog'; // selesai

    const KUSTOMISASI = 'kustomisasi'; // selesai

    const GALERI = 'galeri'; // selesai

    const FAKULTAS_JURUSAN_PRODI = 'fjp'; // selesai

    const DANA = 'dana'; // selesai

    const EVENT = 'event'; // selesai

    const KUESIONER = 'kuesioner';

    const ALL = [
        self::VERIFIKASI,
        self::SKEMA,
        self::UNIT,
        self::ROLE,
        self::SERTIFIKAT,
        self::UJI,
        self::USER,
        self::ASESOR,
        self::MAHASISWA,
        self::MENU,
        self::BLOG,
        self::KUSTOMISASI,
        self::GALERI,
        self::FAKULTAS_JURUSAN_PRODI,
        self::DANA,
        self::EVENT,
        self::KUESIONER
    ];

    protected $table = 'menu';

    public $timestamps = false;

    protected $fillable = [
        'nama', 'route', 'icon'
    ];

    /**
     * mendapatkan data role
     * @param bool $queryReturns
     * @return $this|\Illuminate\Database\Eloquent\Collection
     */
    public function getRoleMenu($queryReturns = false)
    {
        $data = $this->belongsToMany('App\Models\Role', 'role_menu', 'menu_id', 'role_id');
        return $queryReturns ? $data : $data->get();
    }

    /**
     * Mendapatkan model dari nama menu tertentu
     *
     * @return string
     */
    public static function findFromName($menu)
    {
        return static::where('route', strtolower($menu))->first();
    }

    /**
     * @param $route_name
     * @return mixed
     */
    public static function findByRoute($route_name)
    {
        return Menu::where('route', $route_name)->first();
    }
}
