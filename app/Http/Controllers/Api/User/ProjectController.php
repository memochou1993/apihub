<?php

namespace App\Http\Controllers\Api\User;

use App\Project;
use App\Traits\Queryable;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ProjectRequest as Request;
use App\Contracts\ProjectInterface as Repository;
use App\Http\Resources\ProjectResource as Resource;

class ProjectController extends ApiController
{
    use Queryable;

    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Contracts\ProjectInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contracts\ProjectInterface  $reposotory
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
     * @return \App\Http\Resources\ProjectResource
     */
    public function index()
    {
        $projects = $this->reposotory->getUserProjects($this->user, $this->queries);

        return Resource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Http\Resources\ProjectResource
     */
    public function store()
    {
        $project = $this->reposotory->storeProject($this->user, $this->request->all());

        return new Resource($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(string $name)
    {
        $project = $this->reposotory->getUserProjectByName($this->user, $name, $this->queries);

        return new Resource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Project  $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->reposotory->updateProject($project->id, $this->request->all());

        return new Resource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $this->reposotory->destroyProject($project->id);

        return response(null, 204);
    }
}
