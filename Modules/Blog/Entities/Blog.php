<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Vpanel\Core\Fields\DateField;
use Modules\Vpanel\Core\Fields\PointerField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class Blog extends Model
{
    public function getStructure(): ModelStructure
    {
        $structure = new ModelStructure();
        $structure
            ->addField((new StringField('title'))->setTitle('Название')->required())
            ->addField((new DateField('date'))->setTitle('Дата'))
            ->addField((new PointerField('author'))->setModel(Author::class)->setTitle('Автор')->required())
            ->setModelTitle('Новости')
            ->setRecordTitle('Новость')
            ->setAccusativeRecordTitle('новость');

        return $structure;
    }
}