<?php

namespace App\Policies;

use App\Call;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the call.
     *
     * @param  \App\User  $me
     * @param  \App\Call  $call
     * @return mixed
     */
    public function view(User $me, Call $call)
    {
        return in_array($me->id, $call->endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can create calls.
     *
     * @param  \App\User  $me
     * @param  \App\Call  $call
     * @return mixed
     */
    public function create(User $me, Call $call)
    {
        return in_array($me->id, $call->endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can update the call.
     *
     * @param  \App\User  $me
     * @param  \App\Call  $call
     * @return mixed
     */
    public function update(User $me, Call $call)
    {
        return in_array($me->id, $call->endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can delete the call.
     *
     * @param  \App\User  $me
     * @param  \App\Call  $call
     * @return mixed
     */
    public function delete(User $me, Call $call)
    {
        return in_array($me->id, $call->endpoint->project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can restore the call.
     *
     * @param  \App\User  $me
     * @param  \App\Call  $call
     * @return mixed
     */
    public function restore(User $me, Call $call)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the call.
     *
     * @param  \App\User  $me
     * @param  \App\Call  $call
     * @return mixed
     */
    public function forceDelete(User $me, Call $call)
    {
        //
    }
}
