<?php

namespace Database\Seeders;

use App\Models\TaskUserTime;
use Illuminate\Database\Seeder;

class TaskUserTimeTableSeeder extends Seeder
{
    public function run()
    {
        TaskUserTime::factory(20)->create();
    }
}
