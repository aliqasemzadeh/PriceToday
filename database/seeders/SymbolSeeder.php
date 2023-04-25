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
        $symbol->title = __('Bitcoin');
        $symbol->coingecko_id = 'bitcoin';
        $symbol->sort_order = 1;
        $symbol->save();


        $symbol = new Symbol();
        $symbol->symbol = 'ETC';
        $symbol->title = __('Ethereum');
        $symbol->coingecko_id = 'ethereum';
        $symbol->sort_order = 2;
        $symbol->save();
    }
}
