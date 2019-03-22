<?php

namespace App\Http\Controllers\Api\Plaza;

use App\User;
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
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return \App\Http\Resources\EndpointResource
     */
    public function index(User $user, Project $project)
    {
        $endpoints = $this->reposotory->getEndpointsByProject($project, $this->queries);

        return Resource::collection($endpoints);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @param  \App\Endpoint  $endpoint
     * @return \App\Http\Resources\EndpointResource
     */
    public function show(User $user, Project $project, Endpoint $endpoint)
    {
        $endpoints = $this->reposotory->getEndpointByProject($project, $endpoint->id, $this->queries);

        return new Resource($endpoints);
    }
}
