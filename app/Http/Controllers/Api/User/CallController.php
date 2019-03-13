<?php

namespace App\Http\Controllers\Api\User;

use App\Call;
use App\Endpoint;
use App\Traits\Queryable;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CallRequest as Request;
use App\Contracts\CallInterface as Repository;
use App\Http\Resources\CallResource as Resource;

class CallController extends ApiController
{
    use Queryable;

    /**
     * @var \App\Http\Requests\CallRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\CallInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Requests\CallRequest  $request
     * @param  \App\Contracts\CallInterface  $reposotory
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
     * @param  \App\Endpoint  $endpoint
     * @return \App\Http\Resources\CallResource
     */
    public function index(Endpoint $endpoint)
    {
        $this->authorize('view', $endpoint);

        $calls = $this->reposotory->getCallsByEndpoint($endpoint, $this->queries);

        return Resource::collection($calls);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Endpoint  $endpoint
     * @return \App\Http\Resources\CallResource
     */
    public function store(Endpoint $endpoint)
    {
        $this->authorize('create', $endpoint);

        $call = $this->reposotory->storeCall($endpoint, $this->request->all());
        
        return new Resource($call);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Endpoint  $endpoint
     * @param  \App\Call  $call
     * @return \App\Http\Resources\CallResource
     */
    public function show(Endpoint $endpoint, Call $call)
    {
        $this->authorize('view', $call);

        $calls = $this->reposotory->getCall($call->id, $this->queries);

        return new Resource($calls);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Endpoint  $endpoint
     * @param  \App\Call  $call
     * @return \App\Http\Resources\CallResource
     */
    public function update(Endpoint $endpoint, Call $call)
    {
        $this->authorize('view', $call);

        $call = $this->reposotory->updateCall($call->id, $this->request->all());

        return new Resource($call);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Endpoint  $endpoint
     * @param  \App\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endpoint $endpoint, Call $call)
    {
        $this->authorize('view', $call);

        $call = $this->reposotory->destroyCall($call->id);

        return response(null, 204);
    }
}
