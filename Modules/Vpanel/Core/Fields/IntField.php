<?php
namespace Modules\Vpanel\Core\Fields;

class IntField extends Field
{
    public function __construct(public string $type = 'int') {}
}