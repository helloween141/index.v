<?php

namespace Modules\Vpanel\Core\Fields;


use Modules\Vpanel\Core\BaseModel;

abstract class Field
{
    protected string $name;

    protected string $title;

    protected bool $required = false;

    protected bool $identify = false;

    protected bool $readonly = false;

    protected bool $inEditor = true;

    protected bool $inForm = true;

    protected mixed $defaultValue;

    abstract function getSelect(): array;

    public function getWhere(array $filter): string {
        return '';
    }

    public function getJoin(BaseModel|string $mainModel): array {
        return [];
    }

    public static function create(): static
    {
        return new static();
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

    public function hideFromEditor(): Field {
        $this->inEditor = false;
        return $this;
    }

    public function hideFromForm(): Field {
        $this->inForm = false;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
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

    public function showInEditor(): bool
    {
        return $this->inEditor;
    }

    public function isInForm(): bool
    {
        return $this->inForm;
    }
}
