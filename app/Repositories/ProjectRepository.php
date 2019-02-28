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
     * Get all projects.
     * 
     * @param  \App\Project  $project
     * @param  array  $query
     * @return \App\Project
     */
    public function getProjects(Project $project, array $query = [])
    {
        $this->castQuery($query);

        return $project->where($this->where)->paginate();
    }

    /**
     * Get the specified project.
     * 
     * @param  \App\Project  $project
     * @param  array  $query
     * @return \App\Project
     */
    public function getProject(Project $project, array $query = [])
    {
        $this->castQuery($query);

        return $project->where($this->where)->findOrFail($project->id);
    }

    /**
     * Get all projects for the specified user.
     * 
     * @param  \App\User  $user
     * @param  array  $query
     * @return \App\Project
     */
    public function getUserProjects(User $user, array $query = [])
    {
        $this->castQuery($query);

        return $user->projects()->where($this->where)->paginate();
    }

    /**
     * Get the specified project for the specified user.
     * 
     * @param  \App\User  $user
     * @param  array  $query
     * @return \App\Project
     */
    public function getUserProject(User $user, Project $project, array $query = [])
    {
        $this->castQuery($query);

        return $user->projects()->where($this->where)->with($this->with)->findOrFail($project->id);
    }
}
