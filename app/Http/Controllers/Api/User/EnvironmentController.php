<?php

namespace App\Http\Controllers\Api\User;

use App\Project;
use App\Environment;
use App\Traits\Queryable;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\EnvironmentRequest as Request;
use App\Contracts\EnvironmentInterface as Repository;
use App\Http\Resources\EnvironmentResource as Resource;

class EnvironmentController extends ApiController
{
    use Queryable;

    /**
     * @var \App\Http\Requests\EnvironmentRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\EnvironmentInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Requests\EnvironmentRequest  $request
     * @param  \App\Contracts\EnvironmentInterface  $reposotory
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
     * @return \App\Http\Resources\EnvironmentResource
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $environments = $this->reposotory->getEnvironmentsByProject($project, $this->queries);

        return Resource::collection($environments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Project  $project
     * @return \App\Http\Resources\EnvironmentResource
     */
    public function store(Project $project)
    {
        $this->authorize('create', $project);

        $environment = $this->reposotory->storeEnvironment($project, $this->request->all());
        
        return new Resource($environment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @return \App\Http\Resources\EnvironmentResource
     */
    public function show(Project $project, Environment $environment)
    {
        $this->authorize('update', $project);
        $this->authorize('view', $environment);

        $environments = $this->reposotory->getEnvironment($environment->id, $this->queries);

        return new Resource($environments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @return \App\Http\Resources\EnvironmentResource
     */
    public function update(Project $project, Environment $environment)
    {
        $this->authorize('update', $project);
        $this->authorize('update', $environment);

        $environment = $this->reposotory->updateEnvironment($environment->id, $this->request->all());

        return new Resource($environment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Environment $environment)
    {
        $this->authorize('delete', $project);
        $this->authorize('delete', $environment);

        $environment = $this->reposotory->destroyEnvironment($environment->id);

        return response(null, 204);
    }
}
