<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'id' => 1,
            'salary' => 4000000,
            'workday' => 24,
            'location' => 1,
            'accepted_distance' => 100,
            'start' => '07:00',
            'end' => '18:00'
        ]);
    }
}
