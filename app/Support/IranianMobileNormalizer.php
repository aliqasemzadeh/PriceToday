<?php

namespace App\Support;

use Sadegh19b\LaravelPersianValidation\Support\Helper;

class IranianMobileNormalizer
{
    public static function normalize(string $mobile): string
    {
        $mobile = Helper::globalConvertPersianNumbers($mobile, true);
        $digits = preg_replace('/\D+/', '', $mobile);

        if (str_starts_with($digits, '0098')) {
            $digits = substr($digits, 4);
        } elseif (str_starts_with($digits, '98')) {
            $digits = substr($digits, 2);
        }

        if (strlen($digits) === 10 && str_starts_with($digits, '9')) {
            $digits = '0'.$digits;
        }

        return $digits;
    }
}
