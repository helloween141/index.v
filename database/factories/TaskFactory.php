<?php

namespace Database\Factories;

use App\Models\Client;
use App\Modules\Vpanel\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'executor_id' => User::all()->random()->id,
            'client_id' => Client::all()->random()->id,
            'short_description' => $this->faker->text(50),
            'full_description' => $this->faker->text(150),
            'type' => $this->faker->randomElement([
                'consultation', 'content', 'code', 'design',
                'configure', 'warranty', 'other'
            ]),
            'status' => $this->faker->randomElement([
                'new', 'progress', 'complete', 'waiting_answer', 'waiting_payment',
                'additional', 'cancel'
            ]),
            'priority' => $this->faker->randomElement(['low', 'middle', 'high']),
            'finished_at' => $this->faker->dateTimeBetween('-10 day', '+1 day'),
            'client_total_time' => $this->faker->numberBetween(15, 200),
        ];
    }
}
