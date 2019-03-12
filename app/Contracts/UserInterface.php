<?php

namespace App\Contracts;

interface UserInterface
{
    public function searchUsers(string $q);
    public function getUsers(array $queries = []);
    public function getUser(int $id, array $queries = []);
    public function storeUser(array $request);
    public function updateUser(int $id, array $request);
    public function destroyUser(int $id);
}
