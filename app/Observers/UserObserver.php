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
    public function created(User $user)
    {
        UserCreateJob::dispatch($user, Request::ip());
    }
}
