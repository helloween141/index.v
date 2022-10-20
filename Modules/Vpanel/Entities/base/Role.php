<?php

namespace Modules\Vpanel\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\Fields\TextField;
use Modules\Vpanel\Core\ModelStructure;
use Modules\Vpanel\Database\factories\RoleFactory;

class Role extends BaseModel
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
                    ->setName('name')
                    ->setTitle('Название')
                    ->identify()
                    ->required()
                    ->showInFilter()
                    ->showInSearch()
            )
            ->addField(
                TextField::create()
                    ->setName('description')
                    ->setTitle('Описание')
                    ->required()
                    ->showInFilter()
                    ->showInSearch()
            )
            ->setModelTitle('Роли')
            ->setRecordTitle('роль')
            ->setAccusativeRecordTitle('роль');
    }
}
