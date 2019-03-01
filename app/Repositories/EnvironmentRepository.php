<?php

namespace App\Repositories;

use App\User;
use App\Project;
use App\Environment;
use App\Traits\Queryable;
use App\Contracts\EnvironmentInterface;

class EnvironmentRepository implements EnvironmentInterface
{
    use Queryable;

    /**
     * Get all environments of the specified project for the specified user.
     * 
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @param  array  $query
     * @return \App\Environment
     */
    public function getUserProjectEnvironments(User $user, Project $project, array $query = [])
    {
        $this->castQuery($query);

        return $user->projects()->findOrFail($project->id)->environments()->where($this->where)->paginate($this->paginate);
    }

    /**
     * Get the specified environment of the specified project for the specified user.
     * 
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @param  array  $query
     * @return \App\Environment
     */
    public function getUserProjectEnvironment(User $user, Project $project, Environment $environment, array $query = [])
    {
        $this->castQuery($query);
        
        $environment = $user->projects()->findOrFail($project->id)->environments()->where($this->where)->with($this->with)->findOrFail($environment->id);

        return $environment;
    }
}
