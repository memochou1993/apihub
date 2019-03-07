<?php

namespace App\Contracts;

use App\Project;

interface EnvironmentInterface
{
    public function getEnvironments(array $queries = []);
    public function getProjectEnvironments(Project $project, array $queries = []);
    public function getProjectEnvironmentById(Project $project, int $id, array $queries = []);
    public function storeEnvironment(Project $project, array $request);
    public function updateEnvironment(int $id, array $request);
    public function destroyEnvironment(int $id);
}
