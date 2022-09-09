<?php

namespace Modules\File\Entities\base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\File\Database\factories\FileFactory;
use Modules\Vpanel\Core\BaseModel;

class File extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return new FileFactory();
    }
}
