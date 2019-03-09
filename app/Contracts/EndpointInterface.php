<?php

namespace App\Contracts;

use App\Project;

interface EndpointInterface
{
    public function getEndpoints(array $queries = []);
    public function getProjectEndpoints(Project $project, array $queries = []);
    public function getProjectEndpointById(Project $project, int $id, array $queries = []);
    public function storeEndpoint(Project $project, array $request);
    public function updateEndpoint(int $id, array $request);
    public function destroyEndpoint(int $id);
}
