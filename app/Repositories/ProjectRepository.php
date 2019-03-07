<?php

namespace App\Repositories;

use App\User;
use App\Project;
use App\Traits\Queryable;
use App\Contracts\ProjectInterface;
use App\Http\Requests\ProjectRequest as Request;

class ProjectRepository implements ProjectInterface
{
    use Queryable;

    /**
     * @var \App\Project
     */
    protected $project;

    /**
     * Create a new repository instance.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @param  array  $queries
     * @return \App\Project
     */
    public function getProjects(array $queries = [])
    {
        $this->castQueries($queries);

        return $this->project->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  \App\User  $user
     * @param  array  $queries
     * @return \App\Project
     */
    public function getUserProjects(User $user, array $queries = [])
    {
        $this->castQueries($queries);

        return $user->projects()->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  \App\User  $user
     * @param  string  $name
     * @param  array  $queries
     * @return \App\Project
     */
    public function getUserProjectByName(User $user, string $name, array $queries = [])
    {
        $this->castQueries($queries);

        return $user->projects()->where('name', $name)->with($this->with)->firstOrFail();
    }

    /**
     * @param  \App\User  $user
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \App\Project
     */
    public function storeProject(User $user, Request $request)
    {
        $project = $user->projects()->firstOrCreate([
            'name' => $request->name,
        ]);

        $project->update($request->all());

        return $project;
    }

    /**
     * @param  int  $id
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \App\Project
     */
    public function updateProject(int $id, Request $request)
    {
        $project = $this->project->find($id);

        $project->update($request->all());

        return $project;
    }

    /**
     * @param  int  $id
     * @return \App\Project
     */
    public function destroyProject(int $id)
    {
        $project = $this->project->find($id);

        $project->delete();

        return $project;
    }
}
