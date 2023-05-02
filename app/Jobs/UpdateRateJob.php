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

    public $symbols;

    /**
     * Create a new job instance.
     */
    public function __construct($symbols)
    {
        $this->symbols = $symbols;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('COINGECKO_ENDPOINT') . 'simple/price?ids=' . $this->symbols . '&vs_currencies=usd&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true',
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



            $priceData = json_decode($response, true);

            foreach ($priceData as $coingeckoId => $data) {

                $symbol = Symbol::where('coingecko_id', $coingeckoId)->first();
                $symbol->price = $data['usd'];
                $symbol->market_cap = $data['usd_market_cap'];
                $symbol->vol_24h = $data['usd_24h_vol'];
                $symbol->change_24h = $data['usd_24h_change'];
                $symbol->save();

                Rate::create(['symbol' => $symbol->symbol, 'price' => $symbol->price ]);
            }


        } catch (\Exception $e) {
            Log::error("Update Rate:".$e->getMessage());
        }


    }
}
