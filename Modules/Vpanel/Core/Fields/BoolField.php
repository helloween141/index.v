<?php
namespace Modules\Vpanel\Core\Fields;

class BoolField extends Field
{
    public function __construct(public string $type = 'bool') {}
}