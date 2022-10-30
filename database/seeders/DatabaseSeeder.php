<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Run Role Seeder
        $this->call([
            RoleSeeder::class,
        ]);

        // Create user with "owner" privileges
         \App\Models\User::factory()->create([
             'name' => 'Mustafa',
             'email' => 'mustafa@kodegakure.com',
             'role_id' => 1
         ]);

        // Create user with "pegawai" privileges
        \App\Models\User::factory()->create([
            'name' => 'Dodit',
            'email' => 'dodit@kodegakure.com',
        ]);
    }
}
