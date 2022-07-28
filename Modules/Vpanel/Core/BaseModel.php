<?php

namespace Modules\Vpanel\Core;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
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

    public function getList() {
        $list = self::query()
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