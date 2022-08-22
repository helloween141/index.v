<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Vpanel\Core\Fields\Field;

abstract class BaseModel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public static function getStructure(): ModelStructure
    {
        return static::$structure;
    }

    public static function getList()
    {
        $select = ['id'];
        $pointerFields = [];

        $fields = static::getStructure()->getFields();
        foreach ($fields as $field) {
            if ($field->isInEditor()) {
                $select[] = $field->getName();
            }

            if ($field->getType() === 'pointer') {
                $pointerFields[$field->getName()] = $field->getModel();
            }
        }

        $list = static::query()
            ->select($select)
            ->orderBy('id', 'DESC')
            ->paginate();

        $collection = $list->getCollection();

        // Цепляем pointer
        $collection->transform(function ($item) use ($pointerFields) {
            foreach ($item->attributes as $key => $value) {
                $modelClass = $pointerFields[$key] ?? null;
                if ($modelClass) {
                    $model = new $modelClass();
                    $identifyField = $model::getStructure()->getIdentifyField() ?? '';

                    if ($identifyField) {
                        $record = $model::find($value);
                        $item[$key] = $record->$identifyField;
                    }
                }
            }
            return $item;
        });

        return $list;
    }
}