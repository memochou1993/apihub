<?php

namespace Tests\Feature\Api\User;

use App\User;
use App\Project;
use Tests\TestCase;
use App\Environment;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

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

        factory(Project::class)->create()->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/users/me/projects');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'private',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/users/me/projects', [
            'name' => 'new project',
            'description' => 'new description',
            'private' => true,
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'private',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function testShow()
    {
        $user = $this->user;

        $project = factory(Project::class)->create();

        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
                $project->environments()->save(
                    factory(Environment::class)->make()
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/users/me/projects/'.$project->name.'?with=users,environments');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'private',
                'created_at',
                'updated_at',
                'users' => [
                    [
                        'id',
                        'username',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'environments' => [
                    [
                        'id',
                        'name',
                        'description',
                        'variable',
                        'created_at',
                        'updated_at',
                    ]
                ],
            ],
        ]);
    }

    public function testUpdate()
    {
        $user = $this->user;

        $project = factory(Project::class)->create();

        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('PATCH', '/api/users/me/projects/'.$project->id, [
            'name' => 'new project',
            'description' => 'new description',
            'private' => true,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'private',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testDestroy()
    {
        $user = $this->user;
        
        $project = factory(Project::class)->create();

        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('DELETE', '/api/users/me/projects/'.$project->id);

        $response->assertStatus(204);
    }
}
