<?php

namespace Tests\Feature;

use App\Models\Configuration;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_configurations_screen_can_be_rendered()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        Configuration::factory()->create(['id' => 1]);

        $this->followingRedirects()
            ->get(route('configurations.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/Configuration/Index')
            );
    }

    public function test_configurations_edit_screen_can_be_rendered()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $conf = Configuration::factory()->create(['id' => 1]);

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

        $conf = Configuration::factory()->create(['id' => 1]);

        $this->actingAs($owner);

        $this->followingRedirects()
            ->put(route('configurations.update', $conf->id))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors.salary', 'The salary field is required.')
                ->where('errors.workday', 'The workday field is required.')
                ->where('errors.location', 'The location field is required.')
                ->where('errors.accepted_distance', 'The accepted distance field is required.')
            );
    }

    public function test_update_the_conf()
    {
        $this->seed();

        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $conf = Configuration::factory()->create(['id' => 1]);

        $this->actingAs($owner);

        $response = $this->followingRedirects()
            ->put(route('configurations.update', $conf->id), [
                'salary' => '4500000',
                'workday' => '30',
                'location' => '2',
                'accepted_distance' => 50
            ]);

        $response->assertOk()
            ->assertInertia(fn(AssertableInertia $assertableInertia) => $assertableInertia
                ->component('Master/Configuration/Index')
                ->where('errors', [])
                ->where('flash.message', 'Pengaturan berhasil diperbarui.')
            );

        $this->assertDatabaseHas('configurations', [
            'salary' => '4500000',
            'workday' => '30',
            'location' => '2',
            'accepted_distance' => 50
        ]);
    }


    public function test_pegawai_can_not_access_the_conf()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->get(route('configurations.index'))
            ->assertForbidden();
    }
}
