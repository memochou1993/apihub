<?php

namespace App\Repositories;

use App\Call;
use App\Endpoint;
use App\Traits\Queryable;
use App\Contracts\CallInterface;

class CallRepository implements CallInterface
{
    use Queryable;

    /**
     * @var \App\Call
     */
    protected $call;

    /**
     * Create a new repository instance.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    /**
     * @param  array  $queries
     * @return \App\Call
     */
    public function getCalls(array $queries = [])
    {
        $this->castQueries($queries);

        return $this->call->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  \App\Endpoint  $endpoint
     * @param  array  $queries
     * @return \App\Call
     */
    public function getCallsByEndpoint(Endpoint $endpoint, array $queries = [])
    {
        $this->castQueries($queries);

        return $endpoint->calls()->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  int  $id
     * @param  array  $queries
     * @return \App\Call
     */
    public function getCall(int $id, array $queries = [])
    {
        $this->castQueries($queries);

        return $this->call->where($this->where)->with($this->with)->findOrFail($id);
    }

    /**
     * @param  \App\Endpoint  $endpoint
     * @param  array  $request
     * @return \App\Call
     */
    public function storeCall(Endpoint $endpoint, array $request)
    {
        $call = $endpoint->calls()->create($request);

        $call->shouldBeSearchable();

        return $call;
    }

    /**
     * @param  int  $id
     * @param  array  $request
     * @return \App\Call
     */
    public function updateCall(int $id, array $request)
    {
        $call = $this->call->find($id);

        $call->update($request);

        return $call;
    }

    /**
     * @param  int  $id
     * @return \App\Call
     */
    public function destroyCall(int $id)
    {
        $call = $this->call->find($id);

        $call->delete();

        return $call;
    }
}
