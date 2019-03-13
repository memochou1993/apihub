<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $me
     * @param  \App\Project  $project
     * @return mixed
     */
    public function view(User $me, Project $project)
    {
        return in_array($me->id, $project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $me
     * @param  \App\Project  $project
     * @return mixed
     */
    public function create(User $me, Project $project)
    {
        return in_array($me->id, $project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $me
     * @param  \App\Project  $project
     * @return mixed
     */
    public function update(User $me, Project $project)
    {
        return in_array($me->id, $project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $me
     * @param  \App\Project  $project
     * @return mixed
     */
    public function delete(User $me, Project $project)
    {
        return in_array($me->id, $project->users->pluck('id')->all());
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param  \App\User  $me
     * @param  \App\Project  $project
     * @return mixed
     */
    public function restore(User $me, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the project.
     *
     * @param  \App\User  $me
     * @param  \App\Project  $project
     * @return mixed
     */
    public function forceDelete(User $me, Project $project)
    {
        //
    }
}
