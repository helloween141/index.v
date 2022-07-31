<?php
namespace Modules\Vpanel\Core\Fields;

class IntField extends Field
{
    public function __construct(public string $name, public string $type = 'int') {}
}