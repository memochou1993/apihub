<?php

namespace App\Repositories;

use App\User;
use App\Project;
use App\Environment;
use App\Contracts\EnvironmentInterface;

class EnvironmentRepository implements EnvironmentInterface
{
    /**
     * Get all environments of the specified project for the specified user.
     * 
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @param  array  $query
     * @return \App\Environment
     */
    public function getUserProjectEnvironments(User $user, Project $project, array $query)
    {
        return $user->projects()->findOrFail($project->id)->environments()->where($query['where'] ?? [])->paginate();
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
    public function getUserProjectEnvironment(User $user, Project $project, Environment $environment, array $query)
    {
        $environments = $user->projects()->findOrFail($project->id)->environments()->where($query['where'] ?? []);

        if ($query['with'] ?? false) {
            $environments->with(explode(',', $query['with']));
        }

        return $environments->findOrFail($environment->id);
    }
}
