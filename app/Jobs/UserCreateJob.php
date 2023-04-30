<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $ipAddress;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $ipAddress)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->register_ip_address = $this->ipAddress;
        $this->user->save();
    }
}
