<?php

namespace Modules\Blog\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\AuthorFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class Author extends BaseModel
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return new AuthorFactory();
    }
    public function getStructure(): ModelStructure
    {
        return $this->structure
            ->addField((new StringField('name'))->setTitle('Имя')->required())
            ->setModelTitle('Автор')
            ->setRecordTitle('Автор')
            ->setAccusativeRecordTitle('автора');
    }
}