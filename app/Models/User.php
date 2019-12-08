<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Menu;
use Auth;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'password', 'nip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getUserRole($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Role', 'user_role', 'user_id', 'role_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param $nama_role
     * @return bool
     */
    public function hasRole($nama_role)
    {
        return 0 < $this->getUserRole()->where('nama', $nama_role)->count();
    }

    /**
     * mengecek apakah user memiliki hak akses diluar hak akses yang diberikan
     *
     * @param array $checkroles
     * @return boolean
     */
    public function hasRoleOutside($checkroles)
    {
        $roles = Auth::user()->getUserRole(false)->pluck('nama')->toArray();

        return count(array_diff($roles, $checkroles)) > 0;
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUjiAsAdmin($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Uji', 'admin_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUjiAsBagSertifikasi($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Uji', 'bag_sertifikasi_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mendapatkan daftar uji dari user tertentu
     *
     * @param boolean $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsToMany|null|object
     */
    public function getUjiAsAsesor($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Uji', 'asesor_uji', 'user_id', 'uji_id')->withPivot('ttd');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getAsesorSkema($queryReturn = true)
    {
        $data = $this->belongsToMany('App\Models\Skema', 'asesor_skema', 'user_id', 'skema_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getPost($queryReturn = true)
    {
        $data = $this->hasMany('App\Models\Post', 'penulis_id');
        return $queryReturn ? $data : $data->get();
    }

    /**
     * Mengecek apakah user tertentu bisa mengakses menu tertentu
     * 
     * @param Menu $menu
     * @return boolean
     */
    public function hasMenu(Menu $menu)
    {
        $roles = $this->getUserRole()->whereHas('getRoleMenu', function ($query) use ($menu) {
            $query->where('nama', $menu->nama);
        });

        return $roles->count() > 0;
    }

    public function scopeGetHasRole($query, $role)
    {
        return $query->whereHas('getUserRole', function ($query) use ($role) {
            $query->where('nama', $role);
        });
    }

    /**
     * Mendapatkan relasi terhadap tabel TTD user
     *
     * @param boolean $queryreturn
     * @return mixed
     */
    public function getTTD($queryreturn = true)
    {
        $relasi = $this->hasMany(TTDUser::class, 'user_id');

        return $queryreturn ? $relasi : $relasi->get();
    }

    public function getDaftarSuratTugas()
    {
        $files = collect([]);
        $daftar = Storage::files('data/surat_tugas/' . $this->id);

        foreach ($daftar as $file) {
            $files->put(pathinfo($file, PATHINFO_BASENAME), pathinfo($file, PATHINFO_FILENAME));
        }

        return $files;
    }

}
