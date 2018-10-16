<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Skema;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkemaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the skema.
     *
     * @param  \App\User  $user
     * @param  \App\Skema  $skema
     * @return mixed
     */
    public function view(User $user, Skema $skema)
    {
        //
    }

    /**
     * Determine whether the user can create skemas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the skema.
     *
     * @param  \App\User  $user
     * @param  \App\Skema  $skema
     * @return mixed
     */
    public function update(User $user, Skema $skema)
    {
        //
    }

    /**
     * Determine whether the user can delete the skema.
     *
     * @param  \App\User  $user
     * @param  \App\Skema  $skema
     * @return mixed
     */
    public function delete(User $user, Skema $skema)
    {
        //
    }
}
