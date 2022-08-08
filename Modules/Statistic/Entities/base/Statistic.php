<?php

namespace Modules\Statistic\Entities\base;

use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\ModelStructure;

class Statistic extends BaseModel
{

    public static function getStructure(): ModelStructure
    {
        return static::createStructure()
            ->setEditorComponent('StatisticModelEditor')
            ->setModelTitle('Статистика')
            ->setAccusativeRecordTitle('статистику');
    }
}