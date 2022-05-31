<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stage>
 */
class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' => Str::uuid()->toString(),
            'name' => $this->faker->name(),
            'head' => $this->faker->name(),
            'color' =>  $this->faker->hexColor(),
            'value' => rand(1, 99999999),
            'detail' => $this->faker->words(5, true),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'start' => Carbon::now(),
            'end' => Carbon::now()->addDays(30)
        ];
    }
}
