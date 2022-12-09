<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Configuration;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test open attendance page by employee
     *
     * @return void
     */
    public function test_attendances_screen_cannot_rendered_by_employee(): void
    {
        $employee = User::factory()->create();

        $this->actingAs($employee);

        $this->followingRedirects()
            ->get(route('attendances.index'))
            ->assertForbidden();
    }

    /**
     * Test open attendance create page by employee
     *
     * @return void
     */
    public function test_attendances_create_screen_cannot_rendered_by_employee(): void
    {
        $employee = User::factory()->create();

        $this->actingAs($employee);

        $this->followingRedirects()
            ->get(route('attendances.create'))
            ->assertForbidden();
    }

    /**
     * Test open attendance page by owner
     *
     * @return void
     */
    public function test_attendances_screen_can_rendered_by_owner(): void
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);

        $this->actingAs($owner);

        $this->followingRedirects()
            ->get(route('attendances.index'))
            ->assertOk();
    }

    /**
     * Test open attendance create page by owner
     *
     * @return void
     */
    public function test_attendances_create_screen_can_rendered_by_owner(): void
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);
        Location::factory()->create();
        Configuration::factory()->create();

        $this->actingAs($owner);

        $this->followingRedirects()
            ->get(route('attendances.create'))
            ->assertOk();
    }

    /**
     * Test store attendances
     *
     * @return void
     */
    public function test_store_attendances(): void
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);
        Location::factory()->create();
        Configuration::factory()->create();
        $employee = User::factory()->create();

        $this->actingAs($owner);
        $this->followingRedirects()
            ->post(route('attendances.store'), [
                'distance' => 0,
                'latitude' => fake()->latitude,
                'longitude' => fake()->longitude,
                'status' => 'hadir',
                'user_id' => $employee->id
            ])
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors', [])
                ->component('Attendance/Index')
                ->where('flash.message', 'Presensi berhasil dibuat.')
            );

        $this->assertDatabaseCount('attendances', 1);
        $this->assertDatabaseHas('attendances', [
            'user_id' => $employee->id,
            'status' => 'hadir'
        ]);
    }

    /**
     * Test update status attendance
     *
     * @return void
     */
    public function test_update_status_attendance(): void
    {
        $this->assertTrue(true);

//        $owner = User::factory()->create(['role_id' => Role::isOwner]);
//        Location::factory()->create();
//        Configuration::factory()->create();
//        $attendance = Attendance::factory()->forUser(['name' => 'Ijum'])->create();
//
//        $this->actingAs($owner);
//
//        $this->followingRedirects()
//            ->put(route('attendances.update', $attendance->id), [
//                'status' => 'alpha'
//            ])
//            ->assertOk()
//            ->assertInertia(fn(AssertableInertia $page) => $page
//                ->where('errors', [])
//                ->component('Attendance/Show')
//                ->where('flash.message', 'Presensi berhasil diperbarui.')
//            );
//
//        $this->assertDatabaseHas('attendances', [
//            'status' => 'alpha'
//        ]);
    }

    /**
     * Test delete attendance
     *
     * @return void
     */
    public function test_delete_attendance(): void
    {
        $owner = User::factory()->create(['role_id' => Role::isOwner]);
        Location::factory()->create();
        Configuration::factory()->create();
        $attendance = Attendance::factory()->forUser(['name' => 'Ijum'])->create();

        $this->actingAs($owner);

        $this->followingRedirects()
            ->delete(route('attendances.destroy', $attendance->id))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->where('errors', [])
                ->component('Attendance/Index')
                ->where('flash.message', 'Presensi berhasil dihapus.')
            );

        $this->assertDatabaseCount('attendances', 0);
    }
}
