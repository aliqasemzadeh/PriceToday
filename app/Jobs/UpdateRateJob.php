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
        $symbols_array = [];
        $symbols = Symbol::select(['symbol'])->get();
        foreach ($symbols as $symbol) {
            $symbols_array[$symbol->symbol] = $symbol->symbol . 'USDT';
        }
        $client = new Client();
        try {
            $response = $client->get('https://api.binance.com/api/v3/ticker/24hr');
            if ($response->getStatusCode() == 200) {
                $bodyData = json_decode($response->getBody()->getContents(), true);

                foreach ($bodyData as $symbol_ticker) {

                    $symbol = $symbol_ticker['symbol'];
                    if (in_array($symbol, $symbols_array)) {
                        Log::error($symbol_ticker['lastPrice']);
                        Log::error($symbol_ticker['lastPrice']);
                        Rate::create([
                            'price' => $symbol_ticker['lastPrice'],
                            'symbol' => $this->symbol->symbol,
                        ]);
                        $symbolItem = Symbol::where('symbol', $this->symbol->symbol)->first();
                        $symbolItem->price = $symbol_ticker['lastPrice'];
                        $symbolItem->percent = $symbol_ticker['priceChangePercent'];
                        $symbolItem->save();
                    }
                }
            } else {
                Log::critical("UpdateRateJob:" . $response->getStatusCode());
            }
        } catch (\Exception $exception) {
            Log::critical("UpdateRateJob:" . $exception->getMessage());
        }


    }
}
