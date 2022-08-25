<?php
namespace Modules\Vpanel\Core\Fields;

use Modules\Vpanel\Core\BaseModel;

class BoolField extends Field
{
    public function __construct(protected string $type = 'bool') {}
}
