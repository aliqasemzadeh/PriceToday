<?php

namespace App\Jobs;

use App\Models\Rate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
            CURLOPT_URL => env('COINGECKO_ENDPOINT') . 'coins/' . $this->symbol->coingecko_id. '/tickers',
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

        $dataArray = json_decode($response, true);

        $price = $dataArray['tickers'][0]['last'];
        Rate::create([
            'price' => $price,
            'symbol' => $this->symbol->symbol,
        ]);
    }
}
