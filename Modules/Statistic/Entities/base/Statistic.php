<?php

namespace Modules\Statistic\Entities\base;

use Modules\Vpanel\Core\BaseModel;
use Modules\Vpanel\Core\ModelStructure;

class Statistic extends BaseModel
{
    protected static ModelStructure $structure;

    public static function setStructure()
    {
        self::$structure = (new ModelStructure)
            ->setEditorComponent('StatisticModelEditor')
            ->setModelTitle('Статистика')
            ->setAccusativeRecordTitle('статистику');
    }
}