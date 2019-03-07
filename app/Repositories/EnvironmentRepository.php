<?php

namespace App\Repositories;

use App\Project;
use App\Environment;
use App\Traits\Queryable;
use App\Contracts\EnvironmentInterface;
use App\Http\Requests\EnvironmentRequest as Request;

class EnvironmentRepository implements EnvironmentInterface
{
    use Queryable;

    /**
     * @var \App\Environment
     */
    protected $environment;

    /**
     * Create a new repository instance.
     *
     * @param  \App\Environment  $environment
     * @return void
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param  array  $queries
     * @return \App\Environment
     */
    public function getEnvironments(array $queries = [])
    {
        $this->castQueries($queries);

        return $this->environment->where($this->where)->paginate($this->paginate);
    }

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
     * @param  int  $id
     * @param  array  $queries
     * @return \App\Environment
     */
    public function getProjectEnvironmentById(Project $project, int $id, array $queries = [])
    {
        $this->castQueries($queries);
        
        return $project->environments()->where($this->where)->with($this->with)->findOrFail($id);
    }

    /**
     * @param  \App\Project  $project
     * @param  \App\Http\Requests\EnvironmentRequest  $request
     * @return \App\Environment
     */
    public function storeEnvironment(Project $project, Request $request)
    {
        return $project->environments()->create($request->all());
    }

    /**
     * @param  int  $id
     * @param  \App\Http\Requests\EnvironmentRequest  $request
     * @return \App\Environment
     */
    public function updateEnvironment(int $id, Request $request)
    {
        $environment = $this->environment->find($id);

        $environment->update($request->all());

        return $environment;
    }

    /**
     * @param  int  $id
     * @return \App\Environment
     */
    public function destroyEnvironment(int $id)
    {
        $environment = $this->environment->find($id);

        $environment->delete();

        return $environment;
    }
}
