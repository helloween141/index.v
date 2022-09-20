<?php

namespace Modules\Vpanel\Core;

class ChildModel
{
    protected string $title;

    protected string $model;

    protected string $relationKey;

    protected bool $tab = false;

    public static function create(): static
    {
        return new static();
    }

    public function setModel(string|BaseModel $baseModel): ChildModel
    {
        $this->model = $baseModel;
        $this->title = $baseModel::getStructure()->getTitle();

        return $this;
    }

    public function setRelationKey(string $relationKey): static
    {
        $this->relationKey = $relationKey;
        return $this;
    }

    public function showAsTab(): static
    {
        $this->tab = true;
        return $this;
    }
}
