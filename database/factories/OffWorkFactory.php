<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OffWork>
 */
class OffWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start_date' => fake()->dateTimeThisMonth(),
            'finish_date' => fake()->dateTimeThisMonth('+2 weeks'),
            'reason' => fake()->text(),
            'document' => fake()->imageUrl()
        ];
    }
}
