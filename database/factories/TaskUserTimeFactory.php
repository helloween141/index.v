<?php

namespace Database\Factories;

use App\Models\Task;
use App\Modules\Vpanel\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskUserTimeFactory extends Factory
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
            'task_id' => Task::all()->random()->id,
            'timer' => $this->faker->numberBetween(15, 960),
            'client_time' => $this->faker->numberBetween(15, 960),
        ];
    }
}
