<?php

namespace App\Repositories;

use App\User;
use App\Project;
use App\Traits\Queryable;
use App\Contracts\ProjectInterface;

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
    public function getProjectsByUser(User $user, array $queries = [])
    {
        $this->castQueries($queries);

        return $user->projects()->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  int  $id
     * @param  array  $queries
     * @return \App\Project
     */
    public function getProject(int $id, array $queries = [])
    {
        $this->castQueries($queries);

        return $this->project->where($this->where)->with($this->with)->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @param  array  $request
     * @return \App\Project
     */
    public function storeProject(User $user, array $request)
    {
        $project = $user->projects()->where([
            'name' => $request['name'],
        ])->first() ?? $user->projects()->create($request);

        $project->shouldBeSearchable();

        return $project;
    }

    /**
     * @param  int  $id
     * @param  array  $request
     * @return \App\Project
     */
    public function updateProject(int $id, array $request)
    {
        $project = $this->project->find($id);

        $project->update($request);

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
