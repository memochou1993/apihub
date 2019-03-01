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
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Contracts\EnvironmentInterface
     */
    protected $reposotory;

    /**
     * @var array
     */
    protected $errors;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contracts\EnvironmentInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        parent::__construct();

        $this->request = $request;
        
        $this->reposotory = $reposotory;

        $this->setQuery([
            'with' => $request->with,
            'paginate' => $request->paginate,
        ]);

        $this->errors = $this->request->validator ? $this->request->validator->errors() : null;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Project  $project
     * @return \App\Http\Resources\EnvironmentResource
     */
    public function index(Project $project)
    {
        if ($this->errors) {
            return $this->errors;
        }

        $environments = $this->reposotory->getUserProjectEnvironments($this->user, $project, $this->query);

        return Resource::collection($environments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
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
        $environments = $this->reposotory->getUserProjectEnvironment($this->user, $project, $environment, $this->query);

        return new Resource($environments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
