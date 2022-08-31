<?php

namespace Modules\Vpanel\Core\Fields;

class SelectField extends Field
{
    protected array $options = [];

    public function __construct(protected string $type = 'select'){}

    public function setOptions(array $options = []): Field
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
