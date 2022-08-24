<?php
namespace Modules\Vpanel\Core\Fields;

class BoolField extends Field
{
    public function __construct(protected string $type = 'bool') {}

    public function getSelect(): array
    {
        return [
            "{$this->name}"
        ];
    }
}