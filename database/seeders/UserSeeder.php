<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Questocat\Referral\Traits\UserReferral;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    use UserReferral;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'info@pricetoday.ir';
        $user->password = Hash::make('P@ssw0rd321');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user2 = new User();
        $user2->email = 'sasan@pricetoday.ir';
        $user2->password = Hash::make('BestIran@21');
        $user2->email_verified_at = Carbon::now();
        $user2->save();
    }
}
