<?php

namespace App\Console\Commands\Coin;

use App\Models\Symbol;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update coin information base on our database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Symbol::orderBy('sort_order')->chunk(100, function ( $symbols) {
            foreach ($symbols as $symbol) {
                try {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.coingecko.com/api/v3/coins/'. $symbol->coingecko_id,
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
                    $bodyData = json_decode($response);
                    foreach ($bodyData as $coin) {
                        echo $coin->id. "\n";
                    }
                } catch (\Exception $e) {
                    Log::error("Coin-Info:". $e->getMessage());
                }
            }
        });
    }
}
