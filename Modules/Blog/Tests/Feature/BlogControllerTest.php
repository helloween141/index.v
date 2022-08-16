<?php

namespace Modules\Blog\Tests\Feature;

use Modules\Blog\Entities\Author;
use Modules\Blog\Entities\News;
use Modules\Vpanel\Entities\User;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    public function testGetList(): void
    {
        $user = User::get()->first();
        $this->be($user);
        $this->get('/api/vpanel/list/Blog/News')->assertOk();
    }

    public function testGetRecord(): void
    {
        $user = User::get()->first();
        $this->be($user);

        $record = News::factory()->create();
        $this->get('/api/vpanel/record/Blog/News/' . $record->id)->assertOk();

        $record->delete();
    }

    public function testSaveAndDeleteRecord(): void
    {
        $user = User::get()->first();
        $this->be($user);
        $author = Author::factory()->create();

        $response = $this->post('/api/vpanel/Blog/News/save/', [
            'title' => 'Test title',
            'date' => now(),
            'author_id' => $author->id,
            'short_text' => 'test',
            'full_text' => 'test'
        ])->assertOk();

        $id = $response['id'];
        $this->get('/api/vpanel/Blog/News/delete/' . $id)->assertOk();
        $author->delete();
    }

    public function testDeleteRecord(): void
    {
        $user = User::get()->first();
        $this->be($user);

        $record = News::factory()->create();
        $this->get('/api/vpanel/Blog/News/delete/' . $record->id)->assertOk();
    }
}
