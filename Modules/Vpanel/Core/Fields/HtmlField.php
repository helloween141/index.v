<?php
namespace Modules\Vpanel\Core\Fields;

class HtmlField extends Field
{
    public function __construct(public string $name, public string $type = 'html') {}
}