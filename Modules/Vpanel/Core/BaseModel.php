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

    public static function getList($filter = [], $search = "", $withPagination = false)
    {
        $tableName = with(new static)->getTable();

        $query = static::query()->addSelect(["{$tableName}.id"]);

        $fields = static::getStructure()->getFields();
        foreach ($fields as $field) {
            if ($field->isInEditor()) {
                $query->addSelect($field->getSelect(static::class));
            }

            $join = $field->getJoin(static::class);
            if (count($join) > 0) {
                $query->leftJoin(...$join);
            }

            if (count($filter) > 0) {
                $where = $field->getWhere(static::class, $filter);
                if ($where) {
                    if ($field->getType() === "pointer") {
                        $query->whereIn(...$where);
                    }
                    else if (is_array($where[0])) {
                        foreach ($where as $w) {
                            $query->where(...$w);
                        }
                    } else {
                        $query->where(...$where);
                    }
                }
            }
            else if (!empty($search)) {
                if ($field->isInSearch()) {
                    $query->orWhere($field->getName(), "like", "%" . $search . "%");
                }
            }
        }

        // TODO: add order by (id: default)
        $query->orderBy($tableName . ".id", "desc");

        if ($withPagination) {
            $paginatedList = $query->paginate();
            return self::prepareList($paginatedList);
        }

        return $query->get();
    }

    private static function prepareList($list) {
        $collection = $list->getCollection();
        $collection->transform(function ($item) {
            foreach ($item->attributes as $key => $value) {
                if (str_contains($key, ".")) {
                    $prefix = explode(".", $key);
                    $item[$prefix[0]] = array_merge($item[$prefix[0]] ?? [], [$prefix[1] => $value]);
                    unset($item[$key]);
                }
            }
            return $item;
        });

        return $list;
    }
}
