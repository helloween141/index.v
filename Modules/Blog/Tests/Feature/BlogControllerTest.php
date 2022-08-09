<?php

namespace Modules\Blog\Tests\Feature;

use Modules\Blog\Entities\News;
use Modules\Vpanel\Entities\User;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    public function testGetList(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $user->delete();

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
        $response = $this->post('/api/vpanel/Blog/News/save/', [
            'title' => 'Test title',
            'date' => now(),
            'author_id' => 1,
            'short_text' => 'test',
            'full_text' => 'test'
        ])->assertOk();

        $id = $response['id'];
        $this->get('/api/vpanel/Blog/News/delete/' . $id)->assertOk();
    }

    public function testDeleteRecord(): void
    {
        $record = News::factory()->create();
        $this->get('/api/vpanel/Blog/News/delete/' . $record->id)->assertOk();
    }
}
