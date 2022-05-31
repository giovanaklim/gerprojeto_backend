<?php

namespace Database\Factories;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' =>  Str::uuid()->toString(),
            'name' => $this->faker()->name(),
            'head' => $this->faker()->name(),
            'to' =>  Str::uuid()->toString(),
            'value' => rand(1, 99999999),
            'from' =>  Str::uuid()->toString(),
            'details' => $this->faker()->words(5),
            'status' => $this->faker()->randomElement(['open', 'closed']),
            'start' => Carbon::now(),
            'end' => Carbon::now()->addDays(30)
        ];
    }
}
