<?php

namespace App\Jobs;

use App\Models\AlertSymbol;
use App\Models\Symbol;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Symbol $symbol;
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
        $symbolAlerts = AlertSymbol::where('sysmbol_id', $this->symbol->id)->get();
        foreach ($symbolAlerts as $alert) {

        }
    }
}
