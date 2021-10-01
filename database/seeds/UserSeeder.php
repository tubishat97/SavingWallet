<?php

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserProfile::class, 2)->create();

        $user = User::find(1);

        $user->update([
            'username' => 'admin@test.com',
        ]);

        $user->assignRole('superadmin');

        $users = User::where('id', '!=', 1)->get();

        foreach ($users as $key => $value) {
            $value->username = 'user' . $key . '@test.com';
            $value->save();
            $value->assignRole('user');
        }
    }
}
