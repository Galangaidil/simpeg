<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // Test for pegawai start

    public function test_user_with_role_pegawai_can_not_render_users_page()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_render_the_form_to_create_user()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->get(route('users.create'))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_create_new_user()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->post(route('users.store'))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_open_the_form_to_edit_user()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->get(route('users.edit', $pegawai->id))
            ->assertForbidden();
    }

    public function test_user_with_role_pegawai_can_not_update_the_user()
    {
        $pegawai = User::factory()->create();

        $user = User::factory()->create();

        $name = $user->name;
        $email = $user->email;

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->put(route('users.update', $user->id), [
                'name' => 'test update user',
                'email' => 'newemail@kodegakure.com',
                'password' => 'new password',
                'password_confirmation' => 'new password'
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);

        $this->assertEquals($name, $user->name);

        $this->assertEquals($email, $user->email);
    }

    public function test_user_with_role_pegawai_can_not_delete_the_user()
    {
        $pegawai = User::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->delete(route('users.destroy', $user->id))
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'email' => $pegawai->email
        ]);
    }

    // Test for pegawai end

    // Test for owner start

    public function test_user_with_role_owner_can_render_users_page()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $this->followingRedirects()
            ->get(route('users.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/User/Index'));
    }

    public function test_user_with_role_owner_can_render_the_form_to_create_user()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $this->followingRedirects()
            ->get(route('users.create'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/User/Create'));
    }

    public function test_user_with_role_owner_can_create_new_user()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $this->followingRedirects()
            ->post(route('users.store'), [
                'name' => 'test user',
                'email' => 'test@kodegakure.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ])
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/User/Index')
                ->where('errors', [])
                ->where('flash.message', 'Pengguna berhasil ditambahkan.')
            );

        $this->assertDatabaseHas('users', ['email' => 'test@kodegakure.com']);
    }

    public function test_user_with_role_owner_can_open_the_form_to_edit_user()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $pegawai = User::factory()->create();

        $this->actingAs($owner);

        $this->followingRedirects()
            ->get(route('users.edit', $pegawai->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/User/Edit'));
    }

    public function test_user_with_role_owner_can_update_the_user()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $pegawai = User::factory()->create();

        $this->actingAs($owner);

        $this->followingRedirects()
            ->put(route('users.update', $pegawai->id), [
                'name' => 'test update user',
                'email' => 'newemail@kodegakure.com',
                'password' => 'new password',
                'password_confirmation' => 'new password'
            ])
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors', [])
                ->component('Master/User/Index')
                ->where('flash.message', 'Pengguna berhasil diperbarui.')
            );

        $this->assertDatabaseHas('users', [
            'name' => 'test update user',
            'email' => 'newemail@kodegakure.com'
        ]);

        $this->assertNotEquals('newemail@kodegakure.com', $pegawai->email);
        $this->assertNotEquals('test update user', $pegawai->name);
    }

    public function test_user_with_role_owner_can_delete_the_user()
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $pegawai = User::factory()->create();

        $this->actingAs($owner);

        $this->followingRedirects()
            ->delete(route('users.destroy', $pegawai->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Master/User/Index')
                ->where('errors', [])
                ->where('flash.message', 'Pengguna berhasil dihapus.')
            );

        $this->assertDatabaseMissing('users', [
            'id' => $pegawai->id
        ]);
    }

    // Test for owner end

    public function test_user_details_can_be_rendered()
    {
        $pegawai = User::factory()->create();

        $this->actingAs($pegawai);

        $this->followingRedirects()
            ->get(route('users.show', $pegawai->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page->component('Master/User/Show'));
    }


}
