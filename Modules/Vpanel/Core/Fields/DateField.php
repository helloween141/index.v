<?php
namespace Modules\Vpanel\Core\Fields;

class DateField extends Field
{
    public function __construct(public string $name, public string $type = 'date') {}
}