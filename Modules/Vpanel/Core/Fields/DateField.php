<?php
namespace Modules\Vpanel\Core\Fields;

class DateField extends Field
{
    public function __construct(protected string $type = 'date') {}

    public function getSelect(): array
    {
        return [
            "{$this->name}"
        ];
    }
}