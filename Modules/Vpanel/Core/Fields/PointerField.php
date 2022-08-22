<?php
namespace Modules\Vpanel\Core\Fields;

class PointerField extends Field
{
    protected string $model;

    protected bool $isModal = false;

    public function __construct(protected string $type = 'pointer') {}

    public function getModel(): string {
        return $this->model;
    }

    public function setModel(string $model): PointerField {
        $this->model = $model;
        return $this;
    }

    public function modal(): PointerField {
        $this->isModal = true;
        return $this;
    }
}