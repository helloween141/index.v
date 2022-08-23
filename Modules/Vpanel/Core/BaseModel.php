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
        if (!static::$structure) {
            static::$structure = static::defineStructure();
        }
        return static::$structure;
    }

    public static function defineStructure(): ?ModelStructure
    {
        return null;
    }

    public static function getList()
    {
        $select = $where = $join = [];

        $fields = static::getStructure()->getFields();
        foreach ($fields as $field) {
            $select = array_merge($select, $field->getSelect());

            $temp = $field->getWhere([]);
            if ($temp) {
                $where[] = $temp;
            }

            $temp = $field->getJoin(static::class);
            if ($temp) {
                $join[] = $temp;
            }

            if ($field->isInEditor()) {
                $select[] = $field->getName();
            }
        }

        $select = implode(", ", $select);
        $where = implode("AND ", $where);
        $join = implode("", $join);

        $list = DB::select(
            'SELECT ' . $select . ' FROM ' . with(new static)->getTable() . ' ' . $join . ' ' . $where);

        /*$list = static::query()
            ->select($select)
            ->orderBy('id', 'DESC')
            ->paginate();*/

        return $list;
    }
}