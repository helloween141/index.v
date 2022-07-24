<?php

namespace Database\Seeders;

use App\Models\Constant;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        Department::factory()->createMany([
            ['title' => 'SEO'],
            ['title' => 'Разработка'],
            ['title' => 'Маркетинг']
        ]);
    }
}
