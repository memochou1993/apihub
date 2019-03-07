<?php

namespace App\Contracts;

use App\User;
use App\Http\Requests\ProjectRequest as Request;

interface ProjectInterface
{
    public function getProjects(array $queries = []);
    public function getUserProjects(User $user, array $queries = []);
    public function getUserProjectByName(User $user, string $name, array $queries = []);
    public function storeProject(User $user, Request $request);
    public function updateProject(int $id, Request $request);
    public function destroyProject(int $id);
}
