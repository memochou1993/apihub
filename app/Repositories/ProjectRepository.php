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

        return $project->where($this->where)->paginate($this->paginate);
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
     * @param  \App\Project  $project
     * @param  array  $query
     * @return \App\Project
     */
    public function getProject(Project $project, array $query = [])
    {
        $this->castQuery($query);

        return $project->where($this->where)->findOrFail($project->id);
    }
}
