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
        ])->json('GET', '/api/users/me/projects/'.$project->id.'/environments');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'variable',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'meta',
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

        $environment = $project->environments()->first();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/users/me/projects/'.$project->id.'/environments/'.$environment->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'variable',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
