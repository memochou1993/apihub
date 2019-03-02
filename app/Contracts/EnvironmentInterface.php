<?php

namespace App\Contracts;

use App\Project;
use App\Environment;

interface EnvironmentInterface
{
    public function getProjectEnvironments(Project $project, array $query = []);
    public function getProjectEnvironment(Project $project, Environment $environment, array $query = []);
}
