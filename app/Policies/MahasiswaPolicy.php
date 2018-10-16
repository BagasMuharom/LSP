<?php

namespace App\Policies;

use App\Models\{User, Mahasiswa, Role};
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MahasiswaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the mahasiswa.
     *
     * @param  Authenticatable  $user
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return mixed
     */
    public function lihatSyarat(Authenticatable $user, Mahasiswa $mahasiswa)
    {
        if ($user instanceof User)
            return true;

        if ($user->is($mahasiswa))
            return true;

        return false;
    }

    /**
     * Mengecek apakah user terkait bisa menambah mahasiswa baru
     *
     * @param Authenticatable $user
     * @return boolean
     */
    public function create(Authenticatable $user)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Mengecek apakah user terkait bisa memblokir mahasiswa
     *
     * @param Authenticatable $user
     * @param Mahasiswa $mahasiswa
     * @return boolean
     */
    public function blokir(Authenticatable $user, Mahasiswa $mahasiswa)
    {
        if ($user instanceof Mahasiswa)
            return false;

        return $user->hasRole(Role::SUPER_ADMIN);
    }

}
