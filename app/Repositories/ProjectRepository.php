<?php

namespace App\Repositories;

use App\User;
use App\Project;
use App\Traits\Mutable;
use App\Traits\Queryable;
use App\Contracts\ProjectInterface;

class ProjectRepository implements ProjectInterface
{
    use Mutable, Queryable;

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
     * Get all projects.
     * 
     * @param  array  $query
     * @return \App\Project
     */
    public function getProjects(array $query = [])
    {
        $this->castQuery($query);

        return $this->project->where($this->where)->paginate($this->paginate);
    }

    /**
     * Get all projects for the specified user.
     * 
     * @param  \App\User  $user
     * @param  array  $query
     * @return \App\Project
     */
    public function getProjectsByUser(User $user, array $query = [])
    {
        $this->castQuery($query);

        return $user->projects()->where($this->where)->paginate($this->paginate);
    }

    /**
     * Get the specified project.
     * 
     * @param  int  $id
     * @param  array  $query
     * @return \App\Project
     */
    public function getProject(int $id, array $query = [])
    {
        $this->castQuery($query);

        return $this->project->where($this->where)->findOrFail($id);
    }

    /**
     * Store a newly created project.
     * 
     * @param  array  $mutations
     * @return \App\Project
     */
    public function storeProject(array $mutations = [])
    {
        $this->castMutation($mutations);

        $project = $this->project->create($this->create);

        $project->users()->attach($this->attach);

        return $project;
    }

    /**
     * Update the specified project.
     * 
     * @param  array  $mutations
     * @return \App\Project
     */
    public function updateProject(int $id, array $mutations = [])
    {
        $this->castMutation($mutations);

        $project = $this->project->find($id);

        $project->update($this->update);

        return $project;
    }
}
