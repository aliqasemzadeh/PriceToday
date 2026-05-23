<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('assign-role {user_id : The ID of the user}')]
#[Description('Assign the administrator role to a user')]
class AssignRoleToUserCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::query()->find($this->argument('user_id'));

        if ($user === null) {
            $this->error(__('app.commands.assign_role.user_not_found', ['id' => $this->argument('user_id')]));

            return self::FAILURE;
        }

        $user->assignRole('administrator');

        $this->info(__('app.commands.assign_role.success', [
            'name' => $user->name,
            'id' => $user->id,
        ]));

        return self::SUCCESS;
    }
}
