<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configuration>
 */
class ConfigurationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'salary' => 4000000,
            'workday' => 24,
            'location' => 1,
            'accepted_distance' => 100,
            'start' => '07:00',
            'end' => '18:00'
        ];
    }
}
