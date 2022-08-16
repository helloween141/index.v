<?php

namespace Modules\Blog\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\AuthorFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\Field;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class Author extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return new AuthorFactory();
    }

    public static function getStructure(): ModelStructure
    {
        return static::setStructure()
            ->addField(StringField::create()
                ->setName('name')
                ->setTitle('Имя')
                ->identify()
                ->required())
            ->setModelTitle('Авторы')
            ->setRecordTitle('автор')
            ->setAccusativeRecordTitle('автора');
    }
}