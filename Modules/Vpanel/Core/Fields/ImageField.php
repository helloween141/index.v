<?php
namespace Modules\Vpanel\Core\Fields;

class ImageField extends Field
{
    public function __construct(protected string $type = 'image') {}
}
