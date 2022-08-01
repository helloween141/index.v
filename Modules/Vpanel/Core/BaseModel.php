<?php

namespace Modules\Vpanel\Core;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public static function getStructure(): ModelStructure
    {
        return static::$structure;
    }

    public static function getData($recordId = null)
    {
        if ($recordId) {
            return static::query()
                ->where('id', '=', $recordId)
                ->first();
        }

        return static::query()
            ->orderBy('id', 'DESC')
            ->paginate();
    }

}