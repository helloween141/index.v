<?php

namespace Modules\Vpanel\Core;

class ChildModel
{
    protected string $model;

    protected string $key;

    protected bool $tab = false;

    public static function create(): static
    {
        return new static();
    }

    public function setModel(string $baseModel): ChildModel
    {
        /** @var $model BaseModel */
        $this->model = $baseModel;

        return $this;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    public function showAsTab(): static
    {
        $this->tab = true;
        return $this;
    }
}
