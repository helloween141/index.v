<?php

namespace Modules\File\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\File\Database\factories\FileFactory;
use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\Fields\StringField;
use Modules\Vpanel\Core\ModelStructure;

class File extends BaseModel
{
    use HasFactory;

    public $timestamps = true;

    protected static function newFactory(): Factory
    {
        return new FileFactory();
    }

    public static function defineStructure(): ModelStructure
    {
        return ModelStructure::create()
            ->setEditorComponent('FileModelEditor')
            ->setModelTitle('Файлы и изображения')
            ->setRecordTitle('')
            ->setAccusativeRecordTitle('');
    }
}
