<?php

namespace Modules\Vpanel\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\Fields\TextField;
use Modules\Vpanel\Core\ModelStructure;
use Modules\Vpanel\Database\factories\RoleFactory;

class Constant extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return new RoleFactory();
    }

    public static function defineStructure(): ModelStructure
    {
        return ModelStructure::create()
            ->addField(
                StringField::create()
                    ->setName('title')
                    ->setTitle('Название')
                    ->required()
                    ->showInFilter()
                    ->showInSearch()
            )
            ->addField(
                StringField::create()
                    ->setName('name')
                    ->setTitle('Имя переменной')
                    ->identify()
                    ->required()
                    ->showInFilter()
                    ->showInSearch()
            )
            ->setSingle()
            ->setModelTitle('Константы')
            ->setRecordTitle('константа')
            ->setAccusativeRecordTitle('константу');
    }
}
