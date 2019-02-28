<?php

namespace App\Http\Controllers\Api\User;

use App\Project;
use App\Traits\Queryable;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Contracts\ProjectInterface as Repository;
use App\Http\Resources\ProjectResource as Resource;

class ProjectController extends ApiController
{
    use Queryable;

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
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ProjectResource
     */
    public function index()
    {
        $projects = $this->reposotory->getUserProjects($this->user, $this->query);

        return Resource::collection($projects);
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
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(Project $project)
    {
        $project = $this->reposotory->getUserProject($this->user, $project, $this->query);

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
