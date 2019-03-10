<?php

namespace App\Http\Controllers\Api\User;

use App\Project;
use App\Endpoint;
use App\Traits\Queryable;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\EndpointRequest as Request;
use App\Contracts\EndpointInterface as Repository;
use App\Http\Resources\EndpointResource as Resource;

class EndpointController extends ApiController
{
    use Queryable;

    /**
     * @var \App\Http\Requests\EndpointRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\EndpointInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Requests\EndpointRequest  $request
     * @param  \App\Contracts\EndpointInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        parent::__construct();

        $this->request = $request;
        
        $this->reposotory = $reposotory;

        $this->setQueries([
            'with' => $request->with,
            'paginate' => $request->paginate,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Project  $project
     * @return \App\Http\Resources\EndpointResource
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $endpoints = $this->reposotory->getEndpointsByProject($project, $this->queries);

        return Resource::collection($endpoints);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Project  $project
     * @return \App\Http\Resources\EndpointResource
     */
    public function store(Project $project)
    {
        $this->authorize('create', $project);

        $endpoint = $this->reposotory->storeEndpoint($project, $this->request->all());
        
        return new Resource($endpoint);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @param  \App\Endpoint  $endpoint
     * @return \App\Http\Resources\EndpointResource
     */
    public function show(Project $project, Endpoint $endpoint)
    {
        $this->authorize('view', [$project, $endpoint]);

        $endpoints = $this->reposotory->getEndpoint($endpoint->id, $this->queries);

        return new Resource($endpoints);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Project  $project
     * @param  \App\Endpoint  $endpoint
     * @return \App\Http\Resources\EndpointResource
     */
    public function update(Project $project, Endpoint $endpoint)
    {
        $this->authorize('view', [$project, $endpoint]);

        $endpoint = $this->reposotory->updateEndpoint($endpoint->id, $this->request->all());

        return new Resource($endpoint);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @param  \App\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Endpoint $endpoint)
    {
        $this->authorize('view', [$project, $endpoint]);

        $endpoint = $this->reposotory->destroyEndpoint($endpoint->id);

        return response(null, 204);
    }
}
