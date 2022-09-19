<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Entities\Author;
use Modules\Blog\Entities\News;
use Modules\Blog\Entities\NewsTag;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::factory(5)->create();
        News::factory(5)->create();
        NewsTag::factory(5)->create();
    }
}
