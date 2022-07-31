<?php
namespace Modules\Vpanel\Core\Fields;

class BooleanField extends Field
{
    public function __construct(public string $name, public string $type = 'boolean') {}
}