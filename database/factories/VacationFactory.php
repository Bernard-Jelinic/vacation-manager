<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VacationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'depart' => $this->faker->date(),
            'return' => $this->faker->date(),
            'status' => $this->faker->numberBetween(0, 2),
            'admin_read' => $this->faker->boolean(),
            'manager_read' => $this->faker->boolean(),
            'user_notified' => $this->faker->boolean(),
        ];
    }
}
