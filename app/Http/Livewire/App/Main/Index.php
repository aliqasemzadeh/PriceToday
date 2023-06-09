<?php

namespace App\Http\Livewire\App\Main;

use App\Models\Article;
use App\Models\Carousel;
use App\Models\Symbol;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $displayItems = [];

        if(config('bap.home.display-carousels')) {
            $carousels = Carousel::where('language', app()->getLocale())->orderBy('created_at', 'DESC')->take(config('bap.home.count-carousels'))->get();
            $displayItems = ['carousels' => $carousels];
        }

        if(config('bap.home.display-articles')) {
            $articles = Article::where('language', app()->getLocale())->orderBy('created_at', 'DESC')->take(config('bap.home.count-articles'))->get();
            $displayItems['articles'] = $articles;
        }

        if(config('bap.home.display-prices')) {
            if (Cache::has('symbols')) {
                $symbols = Cache::get('symbols');
            } else {
                $symbols = Symbol::orderBy('market_cap', 'DESC')->take(config('bap.home.count-prices'))->get();
                Cache::pull('symbols', $symbols);
            }

            $displayItems['symbols'] = $symbols;
        }

        return view('livewire.app.main.index', $displayItems);
    }
}
