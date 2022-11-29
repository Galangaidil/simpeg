<?php

namespace Database\Seeders;

use App\Models\OffWork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OffWork::factory()->count(1)->forUser([
            'name' => 'Ijum'
        ])->create();
    }
}
