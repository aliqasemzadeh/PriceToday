<?php

namespace App\Utils;

class Format
{
    public static function price($number) : string
    {
        return rtrim(rtrim(sprintf("%10.8f", $number), '0'), '.');
    }
}
