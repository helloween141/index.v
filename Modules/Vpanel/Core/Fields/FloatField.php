<?php
namespace Modules\Vpanel\Core\Fields;

class FloatField extends Field
{
    public function __construct(public string $name, public string $type = 'float') {}
}