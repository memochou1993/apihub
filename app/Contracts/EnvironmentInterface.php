<?php

namespace App\Contracts;

use App\Project;
use App\Http\Requests\EnvironmentRequest as Request;

interface EnvironmentInterface
{
    public function getEnvironments(array $queries = []);
    public function getProjectEnvironments(Project $project, array $queries = []);
    public function getProjectEnvironmentById(Project $project, int $id, array $queries = []);
    public function storeEnvironment(Project $project, Request $request);
    public function updateEnvironment(int $id, Request $request);
    public function destroyEnvironment(int $id);
}
