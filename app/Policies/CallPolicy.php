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
     * @param  \App\User  $user
     * @param  \App\Call  $call
     * @return mixed
     */
    public function view(User $user, Call $call)
    {
        return in_array($user->id, $call->endpoint()->first()->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can create calls.
     *
     * @param  \App\User  $user
     * @param  \App\Call  $call
     * @return mixed
     */
    public function create(User $user, Call $call)
    {
        return in_array($user->id, $call->endpoint()->first()->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can update the call.
     *
     * @param  \App\User  $user
     * @param  \App\Call  $call
     * @return mixed
     */
    public function update(User $user, Call $call)
    {
        return in_array($user->id, $call->endpoint()->first()->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can delete the call.
     *
     * @param  \App\User  $user
     * @param  \App\Call  $call
     * @return mixed
     */
    public function delete(User $user, Call $call)
    {
        return in_array($user->id, $call->endpoint()->first()->project()->first()->users()->get()->pluck('id')->all());
    }

    /**
     * Determine whether the user can restore the call.
     *
     * @param  \App\User  $user
     * @param  \App\Call  $call
     * @return mixed
     */
    public function restore(User $user, Call $call)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the call.
     *
     * @param  \App\User  $user
     * @param  \App\Call  $call
     * @return mixed
     */
    public function forceDelete(User $user, Call $call)
    {
        //
    }
}
