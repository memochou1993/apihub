<?php

namespace App\Http\Controllers\Api\Plaza;

use App\User;
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
     * @var \App\Http\Requests\ProjectRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\ProjectInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Contracts\ProjectInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        parent::__construct();

        $this->request = $request;

        $this->reposotory = $reposotory;

        $this->setQueries([
            'where' => [
                'private' => $request->private ?? false,
            ],
            'with' => $request->with,
            'paginate' => $request->paginate,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \App\Http\Resources\ProjectResource
     */
    public function index(User $user)
    {
        $projects = $this->reposotory->getProjectsByUser($user, $this->queries);

        return Resource::collection($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(User $user, Project $project)
    {
        $project = $this->reposotory->getProjectByUser($user, $project->id, $this->queries);

        return new Resource($project);
    }
}
