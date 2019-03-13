<?php

namespace Tests\Feature\Api\Admin;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/api/admin';

    protected function setUp(): void
    {
        parent::setUp();

        //
    }

    public function testIndex()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/users'
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                collect($user_1)->except(['email_verified_at'])->keys()->toArray(),
            ],
            'links',
            'meta',
        ]);
    }

    public function testStore()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $user_2 = factory(User::class)->make();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/users',
            collect($user_2->toArray())->merge([
                'password' => 'secret',
            ])->toArray()
        );

        $response->assertStatus(201)->assertJsonStructure([
            'data' => collect($user_2)->except(['email_verified_at'])->keys()->toArray(),
        ]);
    }

    public function testCannotCreateDuplicate()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            $this->endpoint.'/users',
            $user_1->toArray()
        );

        $response->assertStatus(422);
    }

    public function testShow()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/users/'.$user_1->id
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($user_1)->except(['email_verified_at'])->keys()->toArray(),
        ]);
    }

    public function testCannotView()
    {
        $user_1 = factory(User::class)->create();

        $user_2 = factory(User::class)->create();

        Passport::actingAs($user_2);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint.'/users/'.$user_1->id
        );

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/users/'.$user_1->id,
            collect($user_1->toArray())->merge([
                'password' => 'secret',
            ])->toArray()
        );

        $response->assertStatus(200)->assertJsonStructure([
            'data' => collect($user_1)->except(['email_verified_at'])->keys()->toArray(),
        ]);
    }

    public function testCannotUpdate()
    {
        $user_1 = factory(User::class)->create();

        $user_2 = factory(User::class)->create();

        Passport::actingAs($user_2);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/users/'.$user_1->id,
            collect($user_1->toArray())->merge([
                'password' => 'secret',
            ])->toArray()
        );

        $response->assertStatus(403);
    }

    public function testCannotUpdateDuplicate()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $user_2 = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            $this->endpoint.'/users/'.$user_1->id,
            collect($user_2->toArray())->merge([
                'password' => 'secret',
            ])->toArray()
        );

        $response->assertStatus(422);
    }

    public function testDestroy()
    {
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $user_2 = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/users/'.$user_2->id
        );

        $response->assertStatus(204);
    }

    public function testCannotDelete()
    {
        $user_1 = factory(User::class)->create();

        $user_2 = factory(User::class)->create();

        Passport::actingAs($user_2);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            $this->endpoint.'/users/'.$user_1->id
        );

        $response->assertStatus(403);
    }
}
