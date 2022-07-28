<?php

namespace Modules\Blog\Entities\base;

use Modules\Blog\Entities\Author;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\DateField;
use Modules\Vpanel\Core\Fields\PointerField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class News extends BaseModel
{
    public function getStructure(): ModelStructure
    {
        return $this->structure
                ->addField((new StringField('title'))->setTitle('Название')->required())
                ->addField((new DateField('date'))->setTitle('Дата'))
                ->addField((new PointerField('author'))->setModel(Author::class)->setTitle('Автор')->required())
                ->setModelTitle('Новости')
                ->setRecordTitle('Новость')
                ->setAccusativeRecordTitle('новость');
    }
}