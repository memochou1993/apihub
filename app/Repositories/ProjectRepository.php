<?php

namespace App\Repositories;

use App\User;
use App\Project;
use App\Contracts\ProjectInterface;

class ProjectRepository implements ProjectInterface
{
    /**
     * Get all projects.
     * 
     * @param  \App\Project  $project
     * @param  array  $query
     * @return \App\Project
     */
    public function getProjects(Project $project, array $query)
    {
        return $project->where($query['where'] ?? [])->paginate();
    }

    /**
     * Get the specified project.
     * 
     * @param  \App\Project  $project
     * @param  array  $query
     * @return \App\Project
     */
    public function getProject(Project $project, array $query)
    {
        return $project->where($query['where'] ?? [])->findOrFail($project->id);
    }

    /**
     * Get all projects for the specified user.
     * 
     * @param  \App\User  $user
     * @param  array  $query
     * @return \App\Project
     */
    public function getUserProjects(User $user, array $query)
    {
        return $user->projects()->where($query['where'] ?? [])->paginate();
    }

    /**
     * Get the specified project for the specified user.
     * 
     * @param  \App\User  $user
     * @param  array  $query
     * @return \App\Project
     */
    public function getUserProject(User $user, Project $project, array $query)
    {
        $projects = $user->projects()->where($query['where'] ?? []);

        if ($query['with'] ?? false) {
            $projects->with(explode(',', $query['with']));
        }

        return $projects->findOrFail($project->id);
    }
}
