<?php

namespace Database\Seeders;

use App\Models\Constant;
use Illuminate\Database\Seeder;

class ConstantTableSeeder extends Seeder
{
    public function run()
    {
        Constant::factory()->create([
            'title' => 'Записей на странице',
            'name' => 'records_per_page',
            'value' => 15,
        ]);
    }
}
