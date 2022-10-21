<?php

namespace Modules\Archive\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Archive\Database\factories\ImageFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class Image extends BaseModel
{
    use HasFactory;

    public $timestamps = true;

    protected static function newFactory(): Factory
    {
        return new ImageFactory();
    }

    public static function defineStructure(): ModelStructure
    {
        return ModelStructure::create()
            ->addField(
                StringField::create()
                    ->setName('name')
                    ->setTitle('Название')
                    ->identify()
                    ->required()
                    ->showInSearch()
            )
            ->addField(
                StringField::create()
                    ->setName('path')
                    ->setTitle('Путь')
                    ->hideFromForm()
            )
            ->setAlias('image')
            ->setEditorComponent('ArchiveModelEditor')
            ->setModelTitle('Изображения')
            ->setRecordTitle('изображение')
            ->setAccusativeRecordTitle('изображение');
    }
}
