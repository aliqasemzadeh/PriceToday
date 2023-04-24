<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Symbol extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function getSymbolIcon($symbol == 'BTC') : string
    {
        if (file_exists(public_path("cryptocurrency-icons/" . strtolower($symbol)) . ".svg")) {
            return asset("cryptocurrency-icons/" . strtolower($symbol) . ".svg");
        } else {
            if (self::does_url_exists("https://s3-symbol-logo.tradingview.com/crypto/XTVC" . strtoupper($symbol) . "--big.svg")) {
                return "https://s3-symbol-logo.tradingview.com/crypto/XTVC" . strtoupper($symbol) . "--big.svg";
            } else {
                return asset("cryptocurrency-icons/coin.svg");
            }
        }
    }
}
