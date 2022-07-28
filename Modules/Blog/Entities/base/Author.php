<?php

namespace Modules\Blog\Entities\base;

use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class Author extends BaseModel
{
    public function getStructure(): ModelStructure
    {
        return $this->structure
            ->addField((new StringField('title'))->setTitle('Имя')->required())
            ->setModelTitle('Автор')
            ->setRecordTitle('Автор')
            ->setAccusativeRecordTitle('автора');
    }
}