<?php
namespace Modules\Vpanel\Core\Fields;

class FloatField extends Field
{
    public function __construct(protected string $type = 'float') {}

    public function getSelect(): array
    {
        return [];
    }
}