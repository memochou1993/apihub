<?php

namespace App\Policies;

use App\User;
use App\Environment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnvironmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the environment.
     *
     * @param  \App\User  $me
     * @param  \App\Environment  $environment
     * @return mixed
     */
    public function view(User $me, Environment $environment)
    {
        return in_array($me->id, $environment->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can create environments.
     *
     * @param  \App\User  $me
     * @param  \App\Environment  $environment
     * @return mixed
     */
    public function create(User $me, Environment $environment)
    {
        return in_array($me->id, $environment->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can update the environment.
     *
     * @param  \App\User  $me
     * @param  \App\Environment  $environment
     * @return mixed
     */
    public function update(User $me, Environment $environment)
    {
        return in_array($me->id, $environment->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can delete the environment.
     *
     * @param  \App\User  $me
     * @param  \App\Environment  $environment
     * @return mixed
     */
    public function delete(User $me, Environment $environment)
    {
        return in_array($me->id, $environment->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can restore the environment.
     *
     * @param  \App\User  $me
     * @param  \App\Environment  $environment
     * @return mixed
     */
    public function restore(User $me, Environment $environment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the environment.
     *
     * @param  \App\User  $me
     * @param  \App\Environment  $environment
     * @return mixed
     */
    public function forceDelete(User $me, Environment $environment)
    {
        //
    }
}
