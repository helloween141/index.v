<?php

namespace Modules\Blog\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\NewsFactory;
use Modules\Blog\Entities\Author;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\Field;
use Modules\Vpanel\Core\ModelStructure;

class News extends BaseModel
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return new NewsFactory();
    }

    public static function getStructure(): ModelStructure
    {
        return static::createStructure()
            ->addField(Field::create('string')->setName('title')->setTitle('Название')->required())
            ->addField(Field::create('date')->setName('date')->setTitle('Дата'))
            ->addField(Field::create('pointer')->setName('author_id')->setModel(Author::class)->setTitle('Автор')->required())
            ->addField(Field::create('text')->setName('short_text')->setTitle('Краткое описание'))
            ->addField(Field::create('text')->setName('full_text')->setTitle('Полное описание'))
            ->setModelTitle('Новости')
            ->setRecordTitle('новость')
            ->setAccusativeRecordTitle('новость');
    }
}