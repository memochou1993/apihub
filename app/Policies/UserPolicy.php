<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $me
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $me, User $user)
    {
        return $me->id === $user->id || $me->id === config('default.admin.id');
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $me
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $me, User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $me
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $me, User $user)
    {
        return $me->id === $user->id || $me->id === config('default.admin.id');
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $me
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $me, User $user)
    {
        return $me->id === $user->id || $me->id === config('default.admin.id');
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param  \App\User  $me
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $me, User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the project.
     *
     * @param  \App\User  $me
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $me, User $user)
    {
        //
    }
}
