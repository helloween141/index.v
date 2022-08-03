<?php
namespace Modules\Vpanel\Core\Fields;

class SelectField extends Field
{
    public array $options = [];

    public function __construct(public string $type = 'select') {}

    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }
}