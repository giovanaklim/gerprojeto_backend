<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'value' => rand(1, 99999999),
            'status' => $this->faker->randomElement(['aberto', 'concluído']),
            'start' => Carbon::now(),
            'end' => Carbon::now()->addDays(30)
        ];
    }
}
