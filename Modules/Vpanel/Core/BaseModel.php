<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Vpanel\Core\Fields\Field;

abstract class BaseModel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected static ?ModelStructure $structure = null;

    public static function getStructure(): ModelStructure
    {
        return static::defineStructure();
    }

    public static function defineStructure(): ?ModelStructure
    {
        return null;
    }

    public static function getList()
    {
        $tableName = with(new static)->getTable();

        $where = $join = $orderBy = [];

        $list = static::query()->addSelect([$tableName . '.id']);

        $fields = static::getStructure()->getFields();
        foreach ($fields as $field) {

            if ($field->showInEditor()) {
                $list->addSelect($field->getSelect());
            }

            $temp = $field->getWhere([]);
            if ($temp) {
                $where[] = $temp;
            }

            $join = $field->getJoin(static::class);
            if (count($join) > 0) {
                $list->leftJoin(...$join);
            }
        }

//        $select = implode(", ", $select);
//        $where = implode("AND ", $where);
//        $join = implode("", $join);
//        $orderBy = implode("ORDER BY id", $orderBy);

//        $list = DB::select(
//            "SELECT {$select} FROM "
//            . with(new static)->getTable() . " "
//            . $join . " "
//            . $where . " "
//            . $orderBy
//        );

        return $list->orderBy($tableName . '.id', 'DESC');
    }
}