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
        $category = new Symbol();
        $category->symbol = 'BTC';
        $category->title = __('Bitcoin');
        $category->coingecko_id = 'bitcoin';
        $category->sort_order = 1;
        $category->save();


        $category = new Symbol();
        $category->symbol = 'ETC';
        $category->title = __('Ethereum');
        $category->coingecko_id = 2;
        $category->save();

    }
}
