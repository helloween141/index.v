<?php
namespace Modules\Vpanel\Core\Fields;

class PointerField extends Field
{
    public string $model;

    public function __construct(public string $name, public string $type = 'pointer') {}

    public function setModel(string $model) {
        $this->model = $model;
        return $this;
    }
}