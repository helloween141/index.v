<?php
namespace Modules\Vpanel\Core\Fields;

class PointerField extends Field
{
    protected string $model;

    public function __construct(protected string $type = 'pointer') {}

    public function getModel(): string {
        return $this->model;
    }

    public function setModel(string $model): Field {
        $this->model = $model;
        return $this;
    }
}