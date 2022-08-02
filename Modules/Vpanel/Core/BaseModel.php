<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public static function createStructure(): ModelStructure
    {
        return new ModelStructure();
    }

    public static function getList()
    {
        $list = static::query()
            ->orderBy('id', 'DESC')
            ->paginate();

        $orderedKeys = [];
        foreach (static::getStructure()->fields as $field) {
            $orderedKeys[] = $field->name;
        }
        $list->getCollection()->transform(function ($value) use ($orderedKeys) {
            $value->attributes = array_replace(array_flip($orderedKeys), $value->attributes);
            return $value;
        });

        return $list;
    }

    public static function getRecord($id)
    {
        return static::query()
            ->where('id', '=', $id)
            ->first();
    }

}