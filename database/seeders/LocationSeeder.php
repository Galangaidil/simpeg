<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create([
            'name' => 'Tauke Sawit Dhea Putri Mustafa',
            'latitude' => -0.3977748,
            'longitude' => 101.6475163,
            'status' => 'active'
        ]);
    }
}
