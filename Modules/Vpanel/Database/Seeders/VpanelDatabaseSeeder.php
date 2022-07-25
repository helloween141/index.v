<?php

namespace Modules\Vpanel\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Vpanel\Entities\User;

class VpanelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.ru',
            'password' => bcrypt('123')
        ]);

        User::factory(3)->create();
    }
}
