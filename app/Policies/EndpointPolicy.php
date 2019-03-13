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
     * @param  \App\User  $me
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function view(User $me, Endpoint $endpoint)
    {
        return in_array($me->id, $endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can create endpoints.
     *
     * @param  \App\User  $me
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function create(User $me, Endpoint $endpoint)
    {
        return in_array($me->id, $endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can update the endpoint.
     *
     * @param  \App\User  $me
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function update(User $me, Endpoint $endpoint)
    {
        return in_array($me->id, $endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can delete the endpoint.
     *
     * @param  \App\User  $me
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function delete(User $me, Endpoint $endpoint)
    {
        return in_array($me->id, $endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can restore the endpoint.
     *
     * @param  \App\User  $me
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function restore(User $me, Endpoint $endpoint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the endpoint.
     *
     * @param  \App\User  $me
     * @param  \App\Endpoint  $endpoint
     * @return mixed
     */
    public function forceDelete(User $me, Endpoint $endpoint)
    {
        //
    }
}
