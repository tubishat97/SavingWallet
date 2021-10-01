<?php

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'user');
            }
        )->get(['id']);

        foreach ($users as $user) {
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->save();
        }
    }
}
