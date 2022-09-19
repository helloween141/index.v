<?php

namespace Modules\Blog\Entities\base;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\factories\NewsTagFactory;

class NewsTag extends Model
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return new NewsTagFactory();
    }


}
