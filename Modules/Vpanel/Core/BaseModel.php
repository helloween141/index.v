<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    protected ModelStructure $structure;

    public function __construct(array $attributes = [])
    {
        $this->structure = new ModelStructure();
        parent::__construct($attributes);
    }

    public function getStructure(): ModelStructure
    {
        return $this->structure;
    }

    public function getList($recordId = null) {
        $query = self::query();
        if ($recordId) {
            $query->where('id', '=', $recordId);
        }

        $list = $query
            ->orderBy('id', 'DESC')
            ->paginate();

        $orderedKeys = [];
        foreach ($this->structure->getFields() as $field) {
            $orderedKeys[] = $field->name;
        }

        $list->getCollection()->transform(function ($value) use ($orderedKeys) {
            $value->attributes = array_replace(array_flip($orderedKeys), $value->attributes);
            return $value;
        });

        return $list;
    }
}