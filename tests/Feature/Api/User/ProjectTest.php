<?php

namespace Tests\Feature\Api\User;

use App\User;
use App\Project;
use App\Endpoint;
use Tests\TestCase;
use App\Environment;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
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

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($project_1)->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $project_1 = factory(Project::class)->make();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects',
            $project_1->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($project_1)->keys()->toArray(),
        ]);
    }

    public function testCannotCreateDuplicate()
    {
        $user = $this->user;

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects',
            $project_1->toArray()
        );

        $response->assertStatus(422);
    }

    public function testShow()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1, $endpoint_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
                $project->endpoints()->save($endpoint_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'?with=users,environments,endpoints'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($project_1)->keys()->merge([
                'users' => [
                    collect($user)->except(['email_verified_at'])->keys()->toArray(),
                ],
                'environments' => [
                    collect($environment_1)->except(['project_id'])->keys()->toArray(),
                ],
                'endpoints' => [
                    collect($endpoint_1)->except(['project_id'])->keys()->toArray(),
                ],
            ])->toArray(),
        ]);
    }

    public function testCannotView()
    {
        $environment_1 = factory(Environment::class)->make();

        $endpoint_1 = factory(Endpoint::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($environment_1, $endpoint_1) {
                $project->environments()->save($environment_1);
                $project->endpoints()->save($endpoint_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'?with=users,environments,endpoints'
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id,
            $project_1->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($project_1)->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $project_1 = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id,
            $project_1->toArray()
        );

        $response->assertStatus(403);
    }

    public function testCannotUpdateDuplicate()
    {
        $user = $this->user;

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id,
            $project_2->toArray()
        );

        $response->assertStatus(422);
    }

    public function testDestroy()
    {
        $user = $this->user;
        
        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project_1->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $project_1 = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project_1->id
        );

        $response->assertStatus(403);
    }
}
