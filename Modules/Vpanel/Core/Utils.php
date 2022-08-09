<?php

namespace Modules\Vpanel\Core;

class Utils
{
    static function toArray($obj, $nestLevel = 0)
    {
        if ($nestLevel > 15) return [];

        if (is_object($obj)) {
            $obj = (array)$obj;
        }

        if (is_array($obj)) {
            $result = [];
            foreach ($obj as $key => $val) {
                $aux = explode("\0", $key);
                $newKey = $aux[count($aux) - 1];
                $result[$newKey] = self::toArray($val, $nestLevel + 1);
            }
        } else {
            $result = $obj;
        }

        return $result;
    }
}