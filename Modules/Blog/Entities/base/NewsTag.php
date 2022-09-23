<?php

namespace Modules\Blog\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\NewsTagFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\IntField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class NewsTag extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return new NewsTagFactory();
    }

    public static function defineStructure(): ModelStructure
    {
        return ModelStructure::create()
            ->addField(
                StringField::create()
                    ->setName('title')
                    ->setTitle('Название')
                    ->identify()
                    ->required()
                    ->showInFilter()
                    ->showInSearch()
            )
            ->addField(
                IntField::create()
                ->setName('news_id')
                ->hideFromEditor()
            )
            ->setModelTitle('Теги')
            ->setRecordTitle('тег')
            ->setAccusativeRecordTitle('тег');
    }
}
