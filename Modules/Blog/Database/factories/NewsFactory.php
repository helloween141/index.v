<?php

namespace Modules\Blog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Blog\Entities\Author;
use Modules\Blog\Entities\News;

class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(2),
            'date' => now(),
            'author_id' => Author::all()->random()->id,
            'short_text' => $this->faker->sentence(5),
            'full_text' => $this->faker->text(),
            'show' => 1,
            'type' => '',
            'price' => ($this->faker->randomDigit() + 1) * 150
        ];
    }
}
