<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Collection;
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
        foreach (static::getStructure()->getFields() as $field) {
            $orderedKeys[] = $field->getName();
        }
        $list->getCollection()->transform(function ($value) use ($orderedKeys) {
            $value->attributes = array_replace(array_flip($orderedKeys), $value->attributes);
            return $value;
        });

        return $list;
    }

    public static function getPointer(): Collection
    {
        return static::all();
    }

    public static function getRecord($id)
    {
        return static::query()
            ->where('id', '=', $id)
            ->first();
    }

}