<?php

namespace App\Jobs;

use App\Models\Rate;
use App\Models\Symbol;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class UpdateRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $symbol;

    /**
     * Create a new job instance.
     */
    public function __construct(Symbol $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.coingecko.com/api/v3/simple/price?ids=' . $this->symbol->coingecko_id . '&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response, true);
        $this->symbol->price = $data[$this->symbol->coingecko_id]['usd'];
        $this->symbol->market_cap = $data[$this->symbol->coingecko_id]['usd_market_cap'];
        $this->symbol->vol_24h = $data[$this->symbol->coingecko_id]['usd_24h_vol'];
        $this->symbol->change_24h = $data[$this->symbol->coingecko_id]['usd_24h_change'];
        $this->symbol->save();

        Rate::create(['symbol' => $this->symbol->sysmbol, 'price' => $this->symbol->price ]);

    }
}
