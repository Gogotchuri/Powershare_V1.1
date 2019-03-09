<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Example Admin',
                'email_verified_at' => Carbon::now(),
                'email' => 'admin@contractzero.com',
                'password' => 'qwert123',
                'role_id' => 1,
            ],
            [
                'name' => 'Example user',
                'email_verified_at' => Carbon::now(),
                'email' => 'user@contractzero.com',
                'password' => 'qwert123',
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();

            $user->name = $userData['name'];
            $user->email_verified_at = $userData['email_verified_at'];
            $user->email = $userData['email'];
            $user->password = Hash::make($userData['password']);
            $user->role_id = $userData['role_id'] ?? 2;

            $user->save();
        }

        factory("App\Models\User", 10)->create();
    }
}
