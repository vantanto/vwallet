<?php

namespace App\Helpers;

class Helper
{
    public static function trimTrailingZeroes($nbr) 
    {
        return strpos($nbr,'.')!==false ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
    }

    public static function numberFormatNoZeroes($num)
    {
        return $num ? self::trimTrailingZeroes(number_format($num, 2)) : $num;
    }
}