<?php

namespace App\Contracts;

use App\Project;
use App\Environment;

interface EnvironmentInterface
{
    public function getProjectEnvironments(Project $project, array $queries = []);
    public function getProjectEnvironment(Project $project, Environment $environment, array $queries = []);
    public function storeEnvironment(Project $project, array $request);
    public function updateEnvironment(int $id, array $request);
}
