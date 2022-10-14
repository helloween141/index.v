<?php

namespace Modules\Vpanel\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Vpanel\Entities\Constant;

class ConstantFactory extends Factory
{
    protected $model = Constant::class;

    public function definition()
    {
        return [];
    }
}
