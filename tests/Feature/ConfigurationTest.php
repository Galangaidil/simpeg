<?php

namespace Tests\Feature;

use App\Models\Configuration;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\ConfigurationSeeder;
use Database\Seeders\LocationSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_configurations_screen_can_be_rendered()
    {
        $this->seed([
            LocationSeeder::class,
            ConfigurationSeeder::class
        ]);

        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $this->followingRedirects()
            ->get(route('configurations.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/Configuration/Index')
                ->where('errors', [])
            );
    }

    public function test_configurations_edit_screen_can_be_rendered()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $conf = Configuration::factory()->create();

        $this->followingRedirects()
            ->get(route('configurations.edit', $conf->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/Configuration/Edit')
            );
    }

    public function test_all_field_should_not_be_empty()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $conf = Configuration::factory()->create();

        $this->actingAs($owner);

        $this->followingRedirects()
            ->put(route('configurations.update', $conf->id))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors.location', 'The location field is required.')
                ->where('errors.accepted_distance', 'The accepted distance field is required.')
            );
    }

    public function test_update_configuration()
    {
        $this->seed([
            LocationSeeder::class,
            ConfigurationSeeder::class
        ]);

        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $newLocation = Location::factory()->create();

        $this->actingAs($owner);

        $response = $this->followingRedirects()
            ->put(route('configurations.update', 1), [
                'location' => $newLocation->id,
                'accepted_distance' => 500,
                'start' => '07:00',
                'end' => '22:00'
            ]);

        $response->assertOk()
            ->assertInertia(fn(AssertableInertia $assertableInertia) => $assertableInertia
                ->component('Master/Configuration/Index')
                ->where('errors', [])
                ->where('flash.message', 'Pengaturan berhasil diperbarui.')
            );

        $this->assertDatabaseHas('configurations', [
            'location' => $newLocation->id,
            'accepted_distance' => 500,
            'start' => '07:00',
            'end' => '22:00'
        ]);
    }

    public function test_pegawai_can_not_open_the_configuration_page()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->get(route('configurations.index'))
            ->assertForbidden();
    }
}
