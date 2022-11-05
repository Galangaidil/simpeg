<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_locations_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('locations.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/Location/Index'));
    }

    public function test_user_with_role_pegawai_can_not_render_the_form_to_create_location()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('locations.create'))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_create_new_location()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->post(route('locations.store'))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_render_the_form_to_edit_location()
    {
        $user = User::factory()->create();

        $location = Location::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('locations.edit', $location->id))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_update_the_location()
    {
        $user = User::factory()->create();

        $location = Location::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->put(route('locations.update', $location->id))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_delete_location()
    {
        $user = User::factory()->create();

        $location = Location::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->delete(route('locations.destroy', $location->id))
            ->assertForbidden();
    }

    public function test_user_with_role_owner_can_render_the_form_to_create_location()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('locations.create'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/Location/Create'));
    }

    public function test_user_with_role_owner_can_create_new_location()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $this->followingRedirects()
            ->post(route('locations.store', [
                'name' => 'UTY Campus',
                'latitude' => '-7.747424881612259',
                'longitude' => '110.3554123613803'
            ]))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors', [])
                ->component('Master/Location/Index')
                ->where('flash.message', 'Lokasi berhasil ditambahkan')
            );
    }

    public function test_user_with_role_owner_can_render_the_form_to_edit_location()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $location = Location::factory()->create();

        $this->followingRedirects()
            ->get(route('locations.edit', $location->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/Location/Edit'));
    }

    public function test_user_with_role_owner_can_edit_the_location()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $location = Location::factory()->create();

        $this->followingRedirects()
            ->put(route('locations.update', $location->id), [
                'name' => 'Something new',
                'latitude' => rand(90, 90),
                'longitude' => rand(-180, 180),
            ])
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/Location/Index')
                ->where('errors', [])
                ->where('flash.message', 'Lokasi berhasil diperbarui')
            );
    }

    public function test_user_with_role_owner_can_delete_the_location()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $location = Location::factory()->create();

        $this->followingRedirects()->delete(route('locations.destroy', $location->id))->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/Location/Index')
                ->where('flash.message', 'Lokasi berhasil dihapus')
            );
    }

    public function test_all_field_on_form_create_location_should_not_be_empty()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $this->followingRedirects()
            ->post(route('locations.store'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors.name', 'The name field is required.')
                ->where('errors.latitude', 'The latitude field is required.')
                ->where('errors.longitude', 'The longitude field is required.')
            );
    }

    public function test_all_field_on_the_form_edit_location_should_not_be_empty()
    {
        $user = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($user);

        $location = Location::factory()->create();

        $this->followingRedirects()
            ->put(route('locations.update', $location->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors.name', 'The name field is required.')
                ->where('errors.latitude', 'The latitude field is required.')
                ->where('errors.longitude', 'The longitude field is required.')
            );
    }

    public function test_location_details_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $location = Location::factory()->create();

        $this->followingRedirects()
            ->get(route('locations.show', $location->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/Location/Show'));
    }
}
