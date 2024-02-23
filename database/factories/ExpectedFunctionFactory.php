<?php

namespace Database\Factories;

use App\Models\ExpectedFunction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExpectedFunction>
 */
class ExpectedFunctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->word,
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}