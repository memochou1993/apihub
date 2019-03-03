<?php

namespace App\Repositories;

use App\Project;
use App\Environment;
use App\Traits\Queryable;
use App\Contracts\EnvironmentInterface;

class EnvironmentRepository implements EnvironmentInterface
{
    use Queryable;

    /**
     * @param  \App\Project  $project
     * @param  array  $queries
     * @return \App\Environment
     */
    public function getProjectEnvironments(Project $project, array $queries = [])
    {
        $this->castQueries($queries);

        return $project->environments()->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @param  array  $queries
     * @return \App\Environment
     */
    public function getProjectEnvironment(Project $project, Environment $environment, array $queries = [])
    {
        $this->castQueries($queries);
        
        return $project->environments()->where($this->where)->with($this->with)->findOrFail($environment->id);
    }
}
