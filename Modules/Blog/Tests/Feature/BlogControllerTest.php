<?php

namespace Modules\Blog\Tests\Feature;

use Modules\Blog\Entities\Author;
use Modules\Blog\Entities\News;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    public function testGetList(): void
    {
        $this->get('/api/vpanel/list/Blog/News')->assertOk();
    }

    public function testGetRecord(): void
    {
        $record = News::factory()->create();
        $this->get('/api/vpanel/record/Blog/News/' . $record->id)->assertOk();
        $record->delete();
    }

    public function testSaveAndDeleteRecord(): void
    {
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
        $record = News::factory()->create();
        $this->get('/api/vpanel/Blog/News/delete/' . $record->id)->assertOk();
    }
}
