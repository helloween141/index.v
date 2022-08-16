<?php
namespace Modules\Vpanel\Core\Fields;

class FileField extends Field
{
    public function __construct(protected string $type = 'file') {}
}