<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShouldLogin()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->post('api/login', $data)
            ->assertStatus(200);
    }

    public function testShouldNotLoginWithInvalidParams()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => '<wrong password>'
        ];

        $this->post('api/login', $data)
            ->assertStatus(404);
    }

    public function testShouldNotLoginWithEmptyParams()
    {
        $this->post('api/login')
            ->assertStatus(302);
    }
}
