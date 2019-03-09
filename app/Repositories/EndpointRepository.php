<?php

namespace App\Repositories;

use App\Project;
use App\Endpoint;
use App\Traits\Queryable;
use App\Contracts\EndpointInterface;

class EndpointRepository implements EndpointInterface
{
    use Queryable;

    /**
     * @var \App\Endpoint
     */
    protected $endpoint;

    /**
     * Create a new repository instance.
     *
     * @param  \App\Endpoint  $endpoint
     * @return void
     */
    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param  array  $queries
     * @return \App\Endpoint
     */
    public function getEndpoints(array $queries = [])
    {
        $this->castQueries($queries);

        return $this->endpoint->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  \App\Project  $project
     * @param  array  $queries
     * @return \App\Endpoint
     */
    public function getProjectEndpoints(Project $project, array $queries = [])
    {
        $this->castQueries($queries);

        return $project->endpoints()->where($this->where)->paginate($this->paginate);
    }

    /**
     * @param  \App\Project  $project
     * @param  int  $id
     * @param  array  $queries
     * @return \App\Endpoint
     */
    public function getProjectEndpointById(Project $project, int $id, array $queries = [])
    {
        $this->castQueries($queries);
        
        return $project->endpoints()->where($this->where)->with($this->with)->findOrFail($id);
    }

    /**
     * @param  \App\Project  $project
     * @param  array  $request
     * @return \App\Endpoint
     */
    public function storeEndpoint(Project $project, array $request)
    {
        return $project->endpoints()->create($request);
    }

    /**
     * @param  int  $id
     * @param  array  $request
     * @return \App\Endpoint
     */
    public function updateEndpoint(int $id, array $request)
    {
        $endpoint = $this->endpoint->find($id);

        $endpoint->update($request);

        return $endpoint;
    }

    /**
     * @param  int  $id
     * @return \App\Endpoint
     */
    public function destroyEndpoint(int $id)
    {
        $endpoint = $this->endpoint->find($id);

        $endpoint->delete();

        return $endpoint;
    }
}
