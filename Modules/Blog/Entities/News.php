<?php

namespace Modules\Blog\Entities;


class News extends \Modules\Blog\Entities\base\News
{
    public static function boot()
    {
        static::saving(function ($model) {});

        parent::boot();
    }

}