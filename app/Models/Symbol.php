<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Symbol extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    public function getSymbolIcon() : string
    {
        if (file_exists(public_path("cryptocurrency-icons/" . strtolower($this->symbol)) . ".svg")) {
            return asset("cryptocurrency-icons/" . strtolower($this->symbol) . ".svg");
        } else {
            if (self::does_url_exists("https://s3-symbol-logo.tradingview.com/crypto/XTVC" . strtoupper($this->symbol) . "--big.svg")) {
                return "https://s3-symbol-logo.tradingview.com/crypto/XTVC" . strtoupper($this->symbol) . "--big.svg";
            } else {
                return asset("cryptocurrency-icons/coin.svg");
            }
        }
    }

    public static function does_url_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

}
