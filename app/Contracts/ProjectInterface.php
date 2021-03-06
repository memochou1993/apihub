<?php

namespace App\Contracts;

use App\User;

interface ProjectInterface
{
    public function searchProjects(string $q);
    public function getProjects(array $queries = []);
    public function getProjectsByUser(User $user, array $queries = []);
    public function getProject(int $id, array $queries = []);
    public function getProjectByUser(User $user, int $id, array $queries = []);
    public function storeProject(User $user, array $request);
    public function updateProject(int $id, array $request);
    public function destroyProject(int $id);
}
