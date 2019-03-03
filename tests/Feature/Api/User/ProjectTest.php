<?php

namespace Tests\Feature\Api\User;

use App\User;
use App\Project;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = Passport::actingAs(
            User::create(config('factories.user'))
        );

        Project::create(config('factories.project'))->users()->attach($user->id);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIndex()
    {
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
        ]);
    }

    public function testShow()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('GET', '/api/users/me/projects/project?with=users');

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
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);
    }
}
