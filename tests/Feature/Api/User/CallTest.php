<?php

namespace Tests\Feature\Api\User;

use App\Call;
use App\User;
use App\Project;
use App\Endpoint;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CallTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/api/users/me';

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        Passport::actingAs($this->user);
    }

    public function testIndex()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();
        
        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint, $call) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($call)->except(['endpoint_id'])->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();
        
        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls',
            $call->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($call)->except(['endpoint_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotCreate()
    {
        $endpoint = factory(Endpoint::class)->make();
        
        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint) {
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls',
            $call->toArray()
        );

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint, $call) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls/'.$call->id.'?with=endpoint'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($call)->except(['endpoint_id'])->keys()->merge([
                'endpoint' => collect($endpoint)->except(['project_id'])->keys()->toArray(),
            ])->toArray(),
        ]);
    }

    public function testCannotView()
    {
        $endpoint = factory(Endpoint::class)->make();

        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint, $call) {
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls/'.$call->id.'?with=endpoint'
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint, $call) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls/'.$call->id,
            $call->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($call)->except(['endpoint_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $endpoint = factory(Endpoint::class)->make();

        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint, $call) {
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls/'.$call->id,
            $call->toArray()
        );

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint, $call) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls/'.$call->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $endpoint = factory(Endpoint::class)->make();

        $call = factory(Call::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint, $call) {
                $project->endpoints()->save($endpoint)->each(
                    function ($endpoint) use ($call) {
                        $endpoint->calls()->save($call);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/endpoints/'.$endpoint->id.'/calls/'.$call->id
        );

        $response->assertStatus(403);
    }
}
