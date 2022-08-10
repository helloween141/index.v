<?php

namespace Modules\Vpanel\Core;

class Utils
{
    public static function toArray($obj, $nestLevel = 0)
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

    public static function translitUrl($value)
    {
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
        );

        $value = mb_strtolower($value);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');

        return $value;
    }
}