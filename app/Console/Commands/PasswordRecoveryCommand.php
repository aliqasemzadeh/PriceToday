<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

#[Signature('password-recovery {user_id : The ID of the user} {password : The new password}')]
#[Description('Change user password')]
class PasswordRecoveryCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::query()->find($this->argument('user_id'));

        if ($user === null) {
            $this->error(__('price-today.commands.password_recovery.user_not_found', ['id' => $this->argument('user_id')]));

            return self::FAILURE;
        }

        $user->password = Hash::make($this->argument('password'));
        $user->save();

        $this->info(__('price-today.commands.password_recovery.success', [
            'name' => $user->name,
            'id' => $user->id,
        ]));

        return self::SUCCESS;
    }
}
