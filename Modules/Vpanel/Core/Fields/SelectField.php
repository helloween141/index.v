<?php

namespace Modules\Vpanel\Core\Fields;

class SelectField extends Field
{
    public array $options = [];

    public function __construct(protected string $type = 'select'){}

    public function setOptions(array $options = []): Field
    {
        $this->options = $options;
        return $this;
    }
}
