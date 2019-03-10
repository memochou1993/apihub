<?php

namespace App\Policies;

use App\User;
use App\Endpoint;
use Illuminate\Auth\Access\HandlesAuthorization;

class EndpointPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the endpoint.
     *
     * @param  \App\User  $user
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function view(User $user, Endpoint $endpoint)
    {
        return in_array($user->id, $endpoint->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can create endpoints.
     *
     * @param  \App\User  $user
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function create(User $user, Endpoint $endpoint)
    {
        return in_array($user->id, $endpoint->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can update the endpoint.
     *
     * @param  \App\User  $user
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function update(User $user, Endpoint $endpoint)
    {
        return in_array($user->id, $endpoint->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can delete the endpoint.
     *
     * @param  \App\User  $user
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function delete(User $user, Endpoint $endpoint)
    {
        return in_array($user->id, $endpoint->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can restore the endpoint.
     *
     * @param  \App\User  $user
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function restore(User $user, Endpoint $endpoint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the endpoint.
     *
     * @param  \App\User  $user
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function forceDelete(User $user, Endpoint $endpoint)
    {
        //
    }
}
