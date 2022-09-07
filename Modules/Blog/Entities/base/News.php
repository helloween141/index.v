<?php

namespace Modules\Blog\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\NewsFactory;
use Modules\Blog\Entities\Author;
use Modules\Vpanel\Behaviors\UrlBehavior;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\BoolField;
use Modules\Vpanel\Core\Fields\DateField;
use Modules\Vpanel\Core\Fields\Field;
use Modules\Vpanel\Core\Fields\HtmlField;
use Modules\Vpanel\Core\Fields\IntField;
use Modules\Vpanel\Core\Fields\PointerField;
use Modules\Vpanel\Core\Fields\SelectField;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\Fields\TextField;
use Modules\Vpanel\Core\ModelStructure;

class News extends BaseModel
{
    use HasFactory, UrlBehavior;

    protected static function newFactory(): Factory
    {
        return new NewsFactory();
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
                BoolField::create()
                    ->setName('show')
                    ->setTitle('Активно')
                    ->showInFilter()
                    ->hideFromEditor()
            )
            ->addField(
                DateField::create()
                    ->setName('date')
                    ->setTitle('Дата')
                    ->showInFilter()
            )
            ->addField(
                IntField::create()
                    ->setName('price')
                    ->setTitle('Стоимость')
                    ->showInFilter()
            )
            ->addField(
                SelectField::create()
                    ->setName('type')
                    ->setTitle('Тип')
                    ->setOptions([
                        'type1' => 'Тип 1',
                        'type2' => 'Тип 2',
                        'type3' => 'Тип 3'
                    ])
                    ->showInFilter()
            )
            ->addField(
                PointerField::create()
                    ->setName('author_id')
                    ->setTitle('Автор')
                    ->required()
                    ->setModel(Author::class)
                    ->modal()
                    ->showInFilter()
                    ->showInSearch()
            )
            ->addField(
                TextField::create()
                    ->setName('short_text')
                    ->setTitle('Краткое описание')
            )
            ->addField(
                HtmlField::create()
                    ->setName('full_text')
                    ->setTitle('Полное описание')
            )
            ->addUrl()
            ->addMeta()
            ->setModelTitle('Новости')
            ->setRecordTitle('новость')
            ->setAccusativeRecordTitle('новость');
    }
}
