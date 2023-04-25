<?php

namespace App\Console\Commands\Sync;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;

class SymbolsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:symbols';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will read all coins and tokens from CoinGecko.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $command = "coins/list";
        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.coingecko.com/api/v3/coins/list',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: __cf_bm=LZuq5DA4iBRHgZHtlRTALMKESXbL57MVslWw6MgCzPg-1682381418-0-AaooT0D9rvMF3u83D2QnPAAw1pHRlxB7I7nifdFmuvNpCcLkJVESgNYn4shntHF8CYVVqNoMIEwAiDagDSzIDVQ='
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $bodyData = json_decode($response);
            foreach ($bodyData as $coin) {
                echo $coin->id. "\n";
            }

        } catch (\Exception $e) {
            Log::error("Sync-Symbols:". $e->getMessage());
        }
    }
}
