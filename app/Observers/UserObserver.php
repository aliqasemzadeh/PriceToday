<?php

namespace App\Observers;

use App\Jobs\UserCreateJob;
use Illuminate\Support\Facades\Request;

class UserObserver
{

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user): void
    {
        UserCreateJob::dispatch($user, Request::ip());
    }


    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        UserUpdateJob::dispatch($user, Request::ip());
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "forceDeleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // ...
    }
}
