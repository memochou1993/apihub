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

        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($endpoint_1)->except(['project_id'])->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints',
            $endpoint_1->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($endpoint_1)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotCreate()
    {
        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints',
            $endpoint_1->toArray()
        );

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $call_1 = factory(Call::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1, $call_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1)->each(
                    function ($endpoint) use ($call_1) {
                        $endpoint->calls()->save($call_1);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints/'.$endpoint_1->id.'?with=project,calls'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($endpoint_1)->except(['project_id'])->keys()->merge([
                'project' => collect($project_1)->keys()->toArray(),
                'calls' => [
                    collect($call_1)->except(['endpoint_id'])->keys()->toArray(),
                ],
            ])->toArray(),
        ]);
    }

    public function testCannotView()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $call_1 = factory(Call::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1, $call_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1)->each(
                    function ($endpoint) use ($call_1) {
                        $endpoint->calls()->save($call_1);
                    }
                );
            }
        );

        $endpoint_2 = factory(Endpoint::class)->make();

        $call_2 = factory(Call::class)->make();

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($endpoint_2, $call_2) {
                $project->endpoints()->save($endpoint_2)->each(
                    function ($endpoint) use ($call_2) {
                        $endpoint->calls()->save($call_2);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints/'.$endpoint_2->id.'?with=project,calls'
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints/'.$endpoint_1->id,
            $endpoint_1->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($endpoint_1)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $call_1 = factory(Call::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1, $call_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1)->each(
                    function ($endpoint) use ($call_1) {
                        $endpoint->calls()->save($call_1);
                    }
                );
            }
        );

        $endpoint_2 = factory(Endpoint::class)->make();

        $call_2 = factory(Call::class)->make();

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($endpoint_2, $call_2) {
                $project->endpoints()->save($endpoint_2)->each(
                    function ($endpoint) use ($call_2) {
                        $endpoint->calls()->save($call_2);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints/'.$endpoint_2->id,
            $endpoint_1->toArray()
        );

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints/'.$endpoint_1->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $user = $this->user;

        $endpoint_1 = factory(Endpoint::class)->make();

        $call_1 = factory(Call::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $endpoint_1, $call_1) {
                $project->users()->attach($user->id);
                $project->endpoints()->save($endpoint_1)->each(
                    function ($endpoint) use ($call_1) {
                        $endpoint->calls()->save($call_1);
                    }
                );
            }
        );

        $endpoint_2 = factory(Endpoint::class)->make();

        $call_2 = factory(Call::class)->make();

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($endpoint_2, $call_2) {
                $project->endpoints()->save($endpoint_2)->each(
                    function ($endpoint) use ($call_2) {
                        $endpoint->calls()->save($call_2);
                    }
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project_1->id.'/endpoints/'.$endpoint_2->id
        );

        $response->assertStatus(403);
    }
}
