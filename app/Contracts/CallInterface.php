<?php

namespace App\Contracts;

use App\Endpoint;

interface CallInterface
{
    public function getCalls(array $queries = []);
    public function getCallsByEndpoint(Endpoint $endpoint, array $queries = []);
    public function getCall(int $id, array $queries = []);
    public function storeCall(Endpoint $endpoint, array $request);
    public function updateCall(int $id, array $request);
    public function destroyCall(int $id);
}
