<?php

namespace App\Console\Commands\Update;

use App\Jobs\UpdateRateJob;
use App\Models\Rate;
use App\Models\Symbol;
use Illuminate\Console\Command;

class RateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all rates with Coinkico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $symbols = Symbol::all();
        foreach($symbols as $symbol)
        {
            UpdateRateJob::dispatch($symbol)->delay(10);
        }
    }
}
