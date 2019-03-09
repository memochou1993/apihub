<?php

namespace App\Contracts;

use App\Project;

interface EnvironmentInterface
{
    public function getEnvironments(array $queries = []);
    public function getEnvironmentsByProject(Project $project, array $queries = []);
    public function getEnvironment(int $id, array $queries = []);
    public function storeEnvironment(Project $project, array $request);
    public function updateEnvironment(int $id, array $request);
    public function destroyEnvironment(int $id);
}
