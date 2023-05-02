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
        $symbol->sort_order = 4;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'USDC';
        $symbol->title = 'USD Coin';
        $symbol->coingecko_id = 'usd-coin';
        $symbol->coingecko_number = 6319;
        $symbol->sort_order = 5;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'XRP';
        $symbol->title = 'Ripple';
        $symbol->coingecko_id ='ripple';
        $symbol->coingecko_number = 44;
        $symbol->sort_order = 6;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'ADA';
        $symbol->title = 'Cardano';
        $symbol->coingecko_id = 'cardano';
        $symbol->coingecko_number = 975;
        $symbol->sort_order = 7;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'DOGE';
        $symbol->title = 'Dogecoin';
        $symbol->coingecko_id = 'dogecoin';
        $symbol->coingecko_number = 5;
        $symbol->sort_order = 8;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'MATIC';
        $symbol->title = 'Polygon';
        $symbol->coingecko_id = 'matic-network';
        $symbol->coingecko_number = 4713;
        $symbol->sort_order = 9;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'SOL';
        $symbol->title = 'Solana';
        $symbol->coingecko_id = 'solana';
        $symbol->coingecko_number = 4128 ;
        $symbol->sort_order = 10;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'DOT';
        $symbol->title = 'Polkadot';
        $symbol->coingecko_id = 'polkadot';
        $symbol->coingecko_number = 12171;
        $symbol->sort_order = 11;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'BUSD';
        $symbol->title = 'Binance USD';
        $symbol->coingecko_id = 'binance-usd';
        $symbol->coingecko_number = 9576;
        $symbol->sort_order = 12;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'LTC';
        $symbol->title = 'Litecoin';
        $symbol->coingecko_id = 'litecoin';
        $symbol->coingecko_number = 2;
        $symbol->sort_order = 13;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'SHIB';
        $symbol->title = 'Shiba Inu';
        $symbol->coingecko_id = 'shiba-inu';
        $symbol->coingecko_number = 11939;
        $symbol->sort_order = 14;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'TRX';
        $symbol->title = 'TRON';
        $symbol->coingecko_id = 'tron';
        $symbol->coingecko_number = 1094;
        $symbol->sort_order = 15;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'AVAX';
        $symbol->title = 'Avalanche';
        $symbol->coingecko_id = 'avalanche-2';
        $symbol->coingecko_number = 12559;
        $symbol->sort_order = 16;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'DAI';
        $symbol->title = 'Dai';
        $symbol->coingecko_id = 'dai';
        $symbol->coingecko_number = 9956;
        $symbol->sort_order = 17;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'UNI';
        $symbol->title = 'Uniswap';
        $symbol->coingecko_id = 'uniswap';
        $symbol->coingecko_number = 12504;
        $symbol->sort_order = 18;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'LINK';
        $symbol->title = 'Chainlink';
        $symbol->coingecko_id = 'chainlink';
        $symbol->coingecko_number = 877;
        $symbol->sort_order = 19;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'TON';
        $symbol->title = 'Toncoin';
        $symbol->coingecko_id = 'the-open-network';
        $symbol->coingecko_number = 17980;
        $symbol->sort_order = 20;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'LEO';
        $symbol->title = 'LEO Token';
        $symbol->coingecko_id = 'leo-token';
        $symbol->coingecko_number = 8418;
        $symbol->sort_order = 21;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'ATOM';
        $symbol->title = 'Cosmos Hub';
        $symbol->coingecko_id = 'cosmos';
        $symbol->coingecko_number = 1481;
        $symbol->sort_order = 22;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'XMR';
        $symbol->title = 'Monero';
        $symbol->coingecko_id = 'monero';
        $symbol->coingecko_number = 69;
        $symbol->sort_order = 23;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'OKB';
        $symbol->title = 'OKB';
        $symbol->coingecko_id = 'okb';
        $symbol->coingecko_number = 4463;
        $symbol->sort_order = 24;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'XLM';
        $symbol->title = 'Stellar';
        $symbol->coingecko_id = 'stellar';
        $symbol->coingecko_number = 100;
        $symbol->sort_order = 25;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'ICP';
        $symbol->title = 'Internet Computer';
        $symbol->coingecko_id = 'internet-computer';
        $symbol->coingecko_number = 14495;
        $symbol->sort_order = 26;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'BCH';
        $symbol->title = 'Bitcoin Cash';
        $symbol->coingecko_id = 'bitcoin-cash';
        $symbol->coingecko_number = 780;
        $symbol->sort_order = 27;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'FIL';
        $symbol->title = 'Filecoin';
        $symbol->coingecko_id = 'filecoin';
        $symbol->coingecko_number = 12817;
        $symbol->sort_order = 28;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'TUSD';
        $symbol->title = 'TrueUSD';
        $symbol->coingecko_id = 'true-usd';
        $symbol->coingecko_number = 3449;
        $symbol->sort_order = 29;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'APT';
        $symbol->title = 'Aptos';
        $symbol->coingecko_id = 'aptos';
        $symbol->coingecko_number = 26455;
        $symbol->sort_order = 30;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'HBAR';
        $symbol->title = 'Hedera';
        $symbol->coingecko_id = 'hedera-hashgraph';
        $symbol->coingecko_number =3688;
        $symbol->sort_order = 31;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'LDO';
        $symbol->title = 'Lido DAO';
        $symbol->coingecko_id = 'lido-dao';
        $symbol->coingecko_number = 13573;
        $symbol->sort_order = 32;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'CRO';
        $symbol->title = 'Cronos';
        $symbol->coingecko_id = 'crypto-com-chain';
        $symbol->coingecko_number = 3710;
        $symbol->sort_order = 33;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'ARB';
        $symbol->title = 'Arbitrum';
        $symbol->coingecko_id = 'arbitrum';
        $symbol->coingecko_number = 16547;
        $symbol->sort_order = 34;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'NEAR';
        $symbol->title = 'NEAR Protocol';
        $symbol->coingecko_id = 'near';
        $symbol->coingecko_number = 10365;
        $symbol->sort_order = 35;
        $symbol->save();

        $symbol = new Symbol();
        $symbol->symbol = 'VET';
        $symbol->title = 'VeChain';
        $symbol->coingecko_id = 'vechain';
        $symbol->coingecko_number = 1167;
        $symbol->sort_order = 36;
        $symbol->save();
    }
}
