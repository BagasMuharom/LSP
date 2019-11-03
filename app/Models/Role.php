<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SUPER_ADMIN = 'SUPER ADMIN';

    const ADMIN = 'ADMIN';

    const SERTIFIKASI = 'SERTIFIKASI';

    const ASESOR = 'ASESOR';

    const KETUA = 'KETUA LSP';

    const ALL = [
        self::SUPER_ADMIN,
        self::ADMIN,
        self::SERTIFIKASI,
        self::ASESOR,
        self::KETUA
    ];

    protected $table = 'role';

    public $timestamps = false;

    protected $fillable = [
        'nama',
    ];

    /**
     * @param $nama_menu
     * @return bool
     */
    public function hasMenu($nama_route)
    {
        $count = $this->getRoleMenu()->where('route', $nama_route)->count();
        return $count > 0;
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getUserRole($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\User', 'user_role', 'role_id', 'user_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getRoleMenu($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Menu', 'role_menu', 'role_id', 'menu_id');
        return $queryReturn ? $data : $data->get();
    }
}
