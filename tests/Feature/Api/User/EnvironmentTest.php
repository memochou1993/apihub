<?php

namespace Tests\Feature\Api\User;

use App\User;
use App\Project;
use Tests\TestCase;
use App\Environment;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvironmentTest extends TestCase
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

        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $environment) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->id.'/environments'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($environment)->except(['project_id'])->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $user = $this->user;

        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project->id.'/environments',
            $environment->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($environment)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotCreate()
    {
        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project->id.'/environments',
            $environment->toArray()
        );

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $user = $this->user;

        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $environment) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->id.'/environments/'.$environment->id.'?with=project'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($environment)->except(['project_id'])->keys()->merge([
                'project' => collect($project)->keys()->toArray(),
            ])->toArray(),
        ]);
    }

    public function testCannotView()
    {
        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($environment) {
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->id.'/environments/'.$environment->id.'?with=project'
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $environment) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project->id.'/environments/'.$environment->id,
            $environment->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($environment)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($environment) {
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project->id.'/environments/'.$environment->id,
            $environment->toArray()
        );

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $user = $this->user;

        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($user, $environment) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project->id.'/environments/'.$environment->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $environment = factory(Environment::class)->make();

        $project = factory(Project::class)->create();
        $project->each(
            function ($project) use ($environment) {
                $project->environments()->save($environment);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project->id.'/environments/'.$environment->id
        );

        $response->assertStatus(403);
    }
}
