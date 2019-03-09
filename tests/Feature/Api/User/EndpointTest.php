<?php

namespace Tests\Feature\Api\User;

use App\User;
use App\Project;
use App\Endpoint;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EndpointTest extends TestCase
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

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->id.'/endpoints'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($endpoint)->except(['project_id'])->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project->id.'/endpoints',
            $endpoint->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($endpoint)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotCreate()
    {
        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project->id.'/endpoints',
            $endpoint->toArray()
        );

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->id.'/endpoints/'.$endpoint->id.'?with=project'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($endpoint)->keys()->toArray()[0],
                'project' => collect($project)->keys()->toArray(),
            ]
        ]);
    }

    public function testCannotView()
    {
        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint) {
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->id.'/endpoints/'.$endpoint->id
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project->id.'/endpoints/'.$endpoint->id,
            $endpoint->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($endpoint)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint) {
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project->id.'/endpoints/'.$endpoint->id,
            $endpoint->toArray()
        );

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $user = $this->user;

        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $endpoint) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project->id.'/endpoints/'.$endpoint->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $endpoint = factory(Endpoint::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($endpoint) {
                $project->endpoints()->save($endpoint);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project->id.'/endpoints/'.$endpoint->id
        );

        $response->assertStatus(403);
    }
}
