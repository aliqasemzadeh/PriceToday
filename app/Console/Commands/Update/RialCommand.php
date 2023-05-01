<?php

namespace App\Console\Commands\Update;

use App\Models\Rate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update tether price base on tether land.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.tetherland.com/currencies',
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

        Rate::create(['symbol' => 'IRR', 'price' => $data['data']['currencies']['USDT']]);
    }
}
