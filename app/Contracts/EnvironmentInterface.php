<?php

namespace App\Contracts;

use App\User;
use App\Project;
use App\Environment;

interface EnvironmentInterface
{
    public function getUserProjectEnvironments(User $user, Project $project, array $query);
    public function getUserProjectEnvironment(User $user, Project $project, Environment $environment, array $query);
}
