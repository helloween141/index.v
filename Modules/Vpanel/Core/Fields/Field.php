<?php

namespace Modules\Vpanel\Core\Fields;


class Field
{
    protected string $name;

    protected string $title;

    protected bool $required = false;

    protected bool $identify = false;

    protected bool $readonly = false;

    protected mixed $defaultValue;

    public static function create($type = '')
    {
        return match ($type) {
            'string' => new StringField(),
            'bool' => new BoolField(),
            'date' => new DateField(),
            'file' => new FileField(),
            'html' => new HtmlField(),
            'int' => new IntField(),
            'float' => new FloatField(),
            'pointer' => new PointerField(),
            'select' => new SelectField(),
            'text' => new TextField(),
            default => throw new \Error("Field type ${$type} doesn't exists"),
        };
    }

    public function setName(string $value): Field
    {
        $this->name = $value;
        return $this;
    }

    public function setTitle(string $value): Field
    {
        $this->title = $value;
        return $this;
    }

    public function setDefault(mixed $value): Field
    {
        $this->defaultValue = $value;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isIdentify(): bool
    {
        return $this->identify;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }
}
