<?php

namespace App\Contracts;

use App\User;
use App\Project;

interface ProjectInterface
{
    public function getProjects(Project $project, array $query = []);
    public function getProjectsByUser(User $user, array $query = []);
    public function getProject(Project $project, array $query = []);
}
