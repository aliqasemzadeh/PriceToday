<?php

namespace Database\Seeders;

use App\Models\Symbol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SymbolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symbol = new Symbol();
        $symbol->symbol = 'BTC';
        $symbol->title = 'Bitcoin';
        $symbol->coingecko_id = 'bitcoin';
        $symbol->coingecko_number = 1;
        $symbol->sort_order = 1;
        $symbol->save();


        $symbol = new Symbol();
        $symbol->symbol = 'ETH';
        $symbol->title = 'Ethereum';
        $symbol->coingecko_id = 'ethereum';
        $symbol->coingecko_number = 279;
        $symbol->sort_order = 2;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'USDT';
        $symbol->title = 'Tether';
        $symbol->coingecko_id = 'tether';
        $symbol->coingecko_number = 325;
        $symbol->sort_order = 3;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'BNB';
        $symbol->title = 'Binance Coin';
        $symbol->coingecko_id = 'binancecoin';
        $symbol->coingecko_number = 825;
        $symbol->sort_order = 3;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'USDC';
        $symbol->title = 'USD Coin';
        $symbol->coingecko_id = 'usd-coin';
        $symbol->coingecko_number = 6319;
        $symbol->sort_order = 4;
        $symbol->save();
    }
}
