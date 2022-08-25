<?php
namespace Modules\Vpanel\Core\Fields;


class IntField extends Field
{
    public function __construct(protected string $type = 'int') {}
}
