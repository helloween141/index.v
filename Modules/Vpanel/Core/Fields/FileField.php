<?php
namespace Modules\Vpanel\Core\Fields;

class FileField extends Field
{
    public function __construct(public string $name, public string $type = 'file') {}
}