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

    protected $endpoint = '/api/users/me';

    protected function setUp(): void
    {
        parent::setUp();

        //
    }

    public function testIndex()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        factory(Project::class)->create()->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects'
        );

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
        $user = factory(User::class)->create();

        Passport::actingAs($user);
        
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects',
            factory(Project::class)->make()->toArray()
        );

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

    public function testCannotCreate()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/projects',
            factory(Project::class)->make()->toArray()
        );

        $response->assertStatus(403);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

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
        ])->get(
            $this->endpoint.'/projects/'.$project->name.'?with=users,environments'
        );

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

    public function testCannotView()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $project = factory(Project::class)->create();

        $project->each(
            function ($project) use ($user) {
                $project->environments()->save(
                    factory(Environment::class)->make()
                );
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/projects/'.$project->name.'?with=users,environments'
        );

        $response->assertStatus(404);
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $project = factory(Project::class)->create();

        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project->id,
            factory(Project::class)->make()->toArray()
        );

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

    public function testCannotUpdate()
    {
        $project = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/projects/'.$project->id,
            factory(Project::class)->make()->toArray()
        );

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);
        
        $project = factory(Project::class)->create();

        $project->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);
        
        $project = factory(Project::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/projects/'.$project->id
        );

        $response->assertStatus(403);
    }
}
