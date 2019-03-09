<?php

namespace App\Contracts;

use App\Project;

interface EndpointInterface
{
    public function getEndpoints(array $queries = []);
    public function getEndpointsByProject(Project $project, array $queries = []);
    public function getEndpoint(int $id, array $queries = []);
    public function storeEndpoint(Project $project, array $request);
    public function updateEndpoint(int $id, array $request);
    public function destroyEndpoint(int $id);
}
