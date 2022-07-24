<?php

namespace Modules\Vpanel\Core\Fields;

abstract class Field
{
    public string $title = '';
    public bool $required = false;
    public bool $identify = false;
    public bool $readonly = false;
    public mixed $defaultValue = '';

    public function setTitle(string $value): Field
    {
        $this->title = $value;
        return $this;
    }

    public function required(): Field
    {
        $this->required = true;
        return $this;
    }

    public function identify(): Field
    {
        $this->identify = true;
        return $this;
    }

    public function readonly(): Field
    {
        $this->readonly = true;
        return $this;
    }

    public function setDefault(mixed $defaultValue): Field
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }
}
