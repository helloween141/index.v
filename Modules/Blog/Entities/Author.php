<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Vpanel\Core\Fields\DateField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class Author extends Model
{
    public function getStructure(): ModelStructure
    {
        $structure = new ModelStructure();
        $structure
            ->addField((new StringField('title'))->setTitle('Имя')->required())
            ->setModelTitle('Автор')
            ->setRecordTitle('Автор')
            ->setAccusativeRecordTitle('автора');

        return $structure;
    }
}