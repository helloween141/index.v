<?php

namespace Modules\Blog\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\NewsFactory;
use Modules\Blog\Entities\Author;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\DateField;
use Modules\Vpanel\Core\Fields\PointerField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\Fields\TextField;
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

    public function getStructure(): ModelStructure
    {
        return $this->structure
                ->addField((new StringField('title'))->setTitle('Название')->required())
                ->addField((new DateField('date'))->setTitle('Дата'))
                ->addField((new PointerField('author_id'))->setModel(Author::class)->setTitle('Автор')->required())
                ->addField((new TextField('short_text'))->setTitle('Краткое описание'))
                ->addField((new TextField('full_text'))->setTitle('Полное описание'))
                ->setModelTitle('Новости')
                ->setRecordTitle('новость')
                ->setAccusativeRecordTitle('новость');
    }
}