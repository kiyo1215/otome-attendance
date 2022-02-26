<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id' => $this->faker->numberBetween($min = 1,$max = 3),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'start_time' => $this->faker->dateTimeBetween($min = '00:00:00', $max = '12:00:00')->format('H:i:s'),
            'end_time' => $this->faker->dateTimeBetween($min = '12:00:00', $max = '24:00:00')->format('H:i:s'),
        ];
    }
}
