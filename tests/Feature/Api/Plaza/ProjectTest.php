<?php

namespace Tests\Feature\Api\Plaza;

use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/api/users';

    protected function setUp(): void
    {
        parent::setUp();

        //
    }

    public function testIndex()
    {
        $user = factory(User::class)->create();

        $project_1 = factory(Project::class)->create([
            'private' => false,
        ]);

        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/'.$user->id.'/projects'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($project_1)->keys()->toArray(),
            ],
            'links',
            'meta',
        ])->assertJsonCount(1, 'data');
    }

    public function testCannotListPrivate()
    {
        $user = factory(User::class)->create();

        $project_1 = factory(Project::class)->create([
            'private' => true,
        ]);

        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/'.$user->id.'/projects'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [],
            'links',
            'meta',
        ])->assertJsonCount(0, 'data');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $project_1 = factory(Project::class)->create([
            'private' => false,
        ]);

        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/'.$user->id.'/projects/'.$project_1->id
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($project_1)->keys()->toArray(),
        ])->assertJsonCount(6, 'data');
    }

    public function testCannotViewPrivate()
    {
        $user = factory(User::class)->create();

        $project_1 = factory(Project::class)->create([
            'private' => true,
        ]);

        $project_1->each(
            function ($project) use ($user) {
                $project->users()->attach($user->id);
            }
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/'.$user->id.'/projects/'.$project_1->id
        );

        $response->assertStatus(404);
    }
}
