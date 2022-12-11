<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ConfigurationSeeder;
use Database\Seeders\LocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiAttendanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test read attendances without authenticated token
     *
     * @return void
     */

    public function test_read_attendances_without_authenticated_token(): void
    {
        $response = $this->getJson(route('v1.attendances.index'));

        $response->assertUnauthorized();
    }

    /**
     * Test store attendances without authenticated token
     *
     * @return void
     */

    public function test_store_attendances_without_authenticated_token(): void
    {
        $response = $this->getJson(route('v1.attendances.store'));

        $response->assertStatus(401)->assertJson([
            'message' => "Unauthenticated."
        ]);
    }

    /**
     * Test read attendances with authenticated user
     *
     * @return void
     */

    public function test_read_attendances_with_authenticated_user(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('v1.attendances.index'));

        $response->assertOk();
    }

    /**
     * Test store attendances with random location
     *
     * @return void
     */

    public function test_store_attendances_with_random_location(): void
    {
        $this->seed([
            LocationSeeder::class,
            ConfigurationSeeder::class
        ]);

        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson(route('v1.attendances.store', [
            'latitude' => fake()->latitude, // random latitude
            'longitude' => fake()->longitude, // random longitude
            'time' => "08:00"
        ]));

        $response->assertUnprocessable();
    }

    /**
     * Test store attendances with incorrect work hour
     *
     * @return void
     */

    public function test_store_attendances_with_incorrect_work_hour(): void
    {
        $this->seed([
            LocationSeeder::class,
            ConfigurationSeeder::class
        ]);

        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson(route('v1.attendances.store', [
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'time' => "03:00" // incorrect work hour
        ]));

        $response->assertUnprocessable();

//        $response->assertNotFound();
    }

    /**
     * Test store attendances
     *
     */
    public function test_store_attendances(): void
    {
        $this->seed([
            LocationSeeder::class,
            ConfigurationSeeder::class
        ]);

        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson(route('v1.attendances.store', [
            'latitude' => -0.3977748,
            'longitude' => 101.6475163,
            'time' => "08:00"
        ]));

        $response->assertOk();

        //        $response->assertNotFound();
    }

}
