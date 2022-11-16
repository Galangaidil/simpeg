<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('v1.auth.login'), [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'iPhone 14'
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'message' => 'Login success'
            ]);
    }

    public function test_login_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('v1.auth.login', [
            'email' => $user->email,
            'password' => 'wrong password',
            'device_name' => 'iPhone'
        ]));

        $response->assertInvalid([
            'email' => 'The provided credentials are incorrect.'
        ]);
    }

    public function test_get_user_profile()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->get(route('v1.auth.userProfile'));

        $response->assertOk();
    }

    public function test_logout()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->post(route('v1.auth.logout'));

        $response->assertOk();
    }
}
