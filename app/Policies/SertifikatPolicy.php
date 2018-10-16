<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Mahasiswa;
use App\Models\Sertifikat;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;

class SertifikatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the sertifikat.
     *
     * @param  Authenticatable  $user
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return mixed
     */
    public function view(Authenticatable $user, Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Determine whether the user can update the sertifikat.
     *
     * @param  Authenticatable  $user
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return mixed
     */
    public function update(Authenticatable $user, Sertifikat $sertifikat)
    {
        return ($user instanceof User && $user->hasRole(Role::SUPER_ADMIN));
    }

    /**
     * Determine whether the user can delete the sertifikat.
     *
     * @param  Authenticatable  $user
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return mixed
     */
    public function delete(Authenticatable $user, Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Mengecek apakah bisa menyetak kuesioner
     *
     * @param Authenticatable $user
     * @param Sertifikat $sertifikat
     * @return boolean
     */
    public function cetakKuesioner(Authenticatable $user, Sertifikat $sertifikat)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $sertifikat->hasKuesioner();
    }

    /**
     * Melakukan impor sertifikat dari file
     *
     * @param Authenticatable $user
     * @return boolean
     */
    public function importSertifikat(Authenticatable $user)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return ($user->hasMenu(Menu::where('route', Menu::SERTIFIKAT)->first()) && ($user->hasRole(Role::SUPER_ADMIN) || $user->hasRole(Role::ADMIN)));
    }

}
