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

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'/environments'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($environment_1)->except(['project_id'])->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project_1->id.'/environments',
            $environment_1->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($environment_1)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotCreate()
    {
        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects/'.$project_1->id.'/environments',
            $environment_1->toArray()
        );

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'/environments/'.$environment_1->id.'?with=project'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($environment_1)->except(['project_id'])->keys()->merge([
                'project' => collect($project_1)->keys()->toArray(),
            ])->toArray(),
        ]);
    }

    public function testCannotView()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $environment_2 = factory(Environment::class)->make();

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($environment_2) {
                $project->environments()->save($environment_2);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project_1->id.'/environments/'.$environment_2->id.'?with=project'
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id.'/environments/'.$environment_1->id,
            $environment_1->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($environment_1)->except(['project_id'])->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $environment_2 = factory(Environment::class)->make();

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($environment_2) {
                $project->environments()->save($environment_2);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project_1->id.'/environments/'.$environment_2->id,
            $environment_1->toArray()
        );

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project_1->id.'/environments/'.$environment_1->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $user = $this->user;

        $environment_1 = factory(Environment::class)->make();

        $project_1 = factory(Project::class)->create();
        $project_1->each(
            function ($project) use ($user, $environment_1) {
                $project->users()->attach($user->id);
                $project->environments()->save($environment_1);
            }
        );

        $environment_2 = factory(Environment::class)->make();

        $project_2 = factory(Project::class)->create();
        $project_2->each(
            function ($project) use ($environment_2) {
                $project->environments()->save($environment_2);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project_1->id.'/environments/'.$environment_2->id
        );

        $response->assertStatus(403);
    }
}
