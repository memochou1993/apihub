<?php

namespace App\Http\Controllers\Api\User;

use App\Project;
use App\Traits\Mutable;
use App\Traits\Queryable;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ProjectRequest as Request;
use App\Contracts\ProjectInterface as Repository;
use App\Http\Resources\ProjectResource as Resource;

class ProjectController extends ApiController
{
    use Mutable, Queryable;

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

        $this->setQuery([
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
        $projects = $this->reposotory->getProjectsByUser($this->user, $this->queries);

        return Resource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->setMutation([
            'create' => $this->request->all(),
            'attach' => $this->user,
        ]);

        return $this->reposotory->storeProject($this->mutations);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project = $this->reposotory->getProject($project->id, $this->queries);

        return new Resource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
