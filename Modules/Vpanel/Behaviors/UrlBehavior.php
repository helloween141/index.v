<?php

namespace Modules\Vpanel\Behaviors;

use Modules\Vpanel\Core\Utils;

trait UrlBehavior
{
    public static function boot()
    {
        static::saving(function ($model) {
            if (isset($model->url) && isset($model->title)) {
                $model->url = Utils::translitUrl($model->title);
            }
        });

        parent::boot();
    }

}