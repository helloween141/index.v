<?php

namespace Modules\Vpanel\Core\Fields;


use Modules\Vpanel\Core\BaseModel;

class StringField extends Field
{
    public function __construct(protected string $type = 'string'){}

    public function getWhere(BaseModel|string $mainModel, array $filter): string {
        $tableName = with(new $mainModel)->getTable();
        if (key_exists($this->name, $filter)) {
            return "{$tableName}.{$this->name} LIKE '%" . $filter[$this->name] . "%'";
        }
        return "";
    }
}
