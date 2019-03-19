<?php

namespace App\Http\Controllers\Api\Plaza;

use App\Traits\Queryable;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UserRequest as Request;
use App\Contracts\UserInterface as Repository;
use App\Http\Resources\UserResource as Resource;

class UserController extends ApiController
{
    use Queryable;

    /**
     * @var \App\Http\Requests\UserRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\UserInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Contracts\UserInterface  $reposotory
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
     * @return \App\Http\Resources\UserResource
     */
    public function index()
    {
        $users = $this->request->q
            ? $this->reposotory->searchUsers($this->request->q)
            : $this->reposotory->getUsers($this->queries);

        return Resource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Http\Resources\UserResource
     */
    public function store()
    {
        $user = $this->reposotory->storeUser($this->request->all());

        return new Resource($user);
    }
}
