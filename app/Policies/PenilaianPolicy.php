<?php

namespace App\Policies;

use App\User;
use App\Uji;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenilaianPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the uji.
     *
     * @param  \App\User  $user
     * @param  \App\Uji  $uji
     * @return mixed
     */
    public function view(User $user, Uji $uji)
    {
        //
    }

    /**
     * Determine whether the user can create ujis.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the uji.
     *
     * @param  \App\User  $user
     * @param  \App\Uji  $uji
     * @return mixed
     */
    public function update(User $user, Uji $uji)
    {
        //
    }

    /**
     * Determine whether the user can delete the uji.
     *
     * @param  \App\User  $user
     * @param  \App\Uji  $uji
     * @return mixed
     */
    public function delete(User $user, Uji $uji)
    {
        //
    }
}
