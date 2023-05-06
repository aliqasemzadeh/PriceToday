<?php

namespace App\Console\Commands\Alert;

use App\Jobs\CheckAlertJob;
use App\Models\Symbol;
use Illuminate\Console\Command;

class SendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check base on price to send alerts.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $symbols = Symbol::all();
        foreach ($symbols as $symbol)
        {
            CheckAlertJob::dispatch($symbol);
        }
    }
}
