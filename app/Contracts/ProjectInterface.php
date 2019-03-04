<?php

namespace App\Contracts;

use App\User;

interface ProjectInterface
{
    public function getProjects(array $queries = []);
    public function getUserProjects(User $user, array $queries = []);
    public function getUserProjectByName(User $user, string $name, array $queries = []);
    public function storeProject(User $user, array $request);
    public function updateProject(int $id, array $request);
    public function destroyProject(int $id);
}
