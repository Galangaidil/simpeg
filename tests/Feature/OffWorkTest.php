<?php

namespace Tests\Feature;

use App\Models\OffWork;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class OffWorkTest extends TestCase
{
    use RefreshDatabase;

    public function test_off_work_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('offworks.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $assertableInertia) => $assertableInertia->component('Offwork/Index'));
    }

    public function test_off_work_create_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('offworks.create'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $assertableInertia) => $assertableInertia->component('Offwork/Create'));
    }

    public function test_insert_new_off_work()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->post(route('offworks.store'), [
                'start_date' => '2022-11-09',
                'finish_date' => '2022-11-12',
                'reason' => "I'm sick",
            ])
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $assertableInertia) => $assertableInertia
                    ->where('errors', [])
                    ->component('Offwork/Index')
                    ->where('flash.message', 'Permohonan cuti berhasil dibuat.')
            );

        $this->assertDatabaseHas('off_works', [
            'user_id' => $user->id,
            'start_date' => '2022-11-09',
            'finish_date' => '2022-11-12',
            'reason' => "I'm sick"
        ]);
    }

    public function test_show_off_work()
    {
        $user = User::factory()->create();

        $offWorks = OffWork::factory()->for($user)->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('offworks.show', $offWorks->id))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $assertableInertia) => $assertableInertia->component('Offwork/Show'));
    }

    public function test_form_edit_off_work_can_be_rendered()
    {
        $user = User::factory()->create();

        $offWorks = OffWork::factory()->for($user)->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->get(route('offworks.edit', $offWorks->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $assertableInertia) => $assertableInertia->component('Offwork/Edit'));
    }

    public function test_update_off_work()
    {
        $user = User::factory()->create();

        $offWorks = OffWork::factory()->for($user)->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->put(route('offworks.update', $offWorks->id), [
                'start_date' => '2022-11-12',
                'finish_date' => '2022-11-15',
                'reason' => "I'm sick update",
            ])
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $assertableInertia) => $assertableInertia
                ->where('errors', [])
                ->where('flash.message', 'Permohonan cuti berhasil diperbarui.')
                ->component('Offwork/Index')
        );

        $this->assertDatabaseHas('off_works', [
            'user_id' => $offWorks->user_id,
            'start_date' => '2022-11-12',
            'finish_date' => '2022-11-15',
            'reason' => "I'm sick update",
        ]);
    }

    public function test_delete_off_work()
    {
        $user = User::factory()->create();

        $offWorks = OffWork::factory()->for($user)->create();

        $this->actingAs($user);

        $this->followingRedirects()
            ->delete(route('offworks.destroy', $offWorks->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $assertableInertia) => $assertableInertia
                ->where('errors', [])
                ->where('flash.message', 'Permohonan cuti berhasil dihapus.')
                ->component('Offwork/Index')
        );
    }
}
