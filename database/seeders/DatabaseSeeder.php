<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConstantTableSeeder::class);

        $this->call(DepartmentTableSeeder::class);

        $this->call(ClientTableSeeder::class);

        $this->call(UserTableSeeder::class);

        $this->call(TaskTableSeeder::class);

        $this->call(TaskUserTimeTableSeeder::class);
    }
}
