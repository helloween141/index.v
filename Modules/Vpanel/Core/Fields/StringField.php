<?php
namespace Modules\Vpanel\Core\Fields;

class StringField extends Field
{
    public function __construct(protected string $type = 'string') {}
}