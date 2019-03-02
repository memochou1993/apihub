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
     * @param  \App\Project  $project
     * @param  array  $query
     * @return \App\Environment
     */
    public function getProjectEnvironments(Project $project, array $query = [])
    {
        $this->castQuery($query);

        return $project->environments()->where($this->where)->paginate($this->paginate);
    }

    /**
     * Get the specified environment of the specified project for the specified user.
     * 
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @param  array  $query
     * @return \App\Environment
     */
    public function getProjectEnvironment(Project $project, Environment $environment, array $query = [])
    {
        $this->castQuery($query);
        
        return $project->environments()->where($this->where)->with($this->with)->findOrFail($environment->id);
    }
}
