<?php

namespace Tests\Feature\Api\Plaza;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
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
        $user_1 = factory(User::class)->create();

        Passport::actingAs($user_1);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            $this->endpoint
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
            $this->endpoint,
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
            $this->endpoint,
            $user_1->toArray()
        );

        $response->assertStatus(422);
    }
}
