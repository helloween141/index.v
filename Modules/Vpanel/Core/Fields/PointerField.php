<?php

namespace Modules\Vpanel\Core\Fields;

use Modules\Vpanel\Core\BaseModel;

class PointerField extends Field
{
    /** @var string|BaseModel */
    protected mixed $model;

    protected bool $isModal = false;

    public function __construct(protected string $type = 'pointer')
    {
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): PointerField
    {
        $this->model = $model;
        return $this;
    }

    public function modal(): PointerField
    {
        $this->isModal = true;
        return $this;
    }

    public function getSelect(): array
    {
        /** @var string|BaseModel */
        $model = $this->getModel();

        $tableName = with(new $model)->getTable();
        $identifyFieldName = $model::getStructure()->getIdentifyField();

        return [
            "{$tableName}_{$this->name}.id",
            "{$tableName}_{$this->name}.{$identifyFieldName}"
        ];
    }

    public function getWhere(array $filter): string
    {
        $tableName = '';
        if (key_exists($this->name, $filter)) {
            return "{$tableName}_{$this->name}.id in (" . implode(", ", $filter[$this->name]) . ")";
        }
        return "";
    }

    public function getJoin(BaseModel|string $mainModel): string
    {
        /** @var string|BaseModel */
        $model = $this->getModel();

        $tableName = with(new $model)->getTable();
        $mainTableMain = with(new $mainModel)->getTable();

        return "LEFT JOIN {$tableName} {$tableName}_{$this->name} ON {$mainTableMain}.{$this->name} = {$tableName}_{$this->name}.id";
    }
}