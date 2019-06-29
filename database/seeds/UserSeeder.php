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
                'name' => 'ბექა დალაქიშვილი',
                'email_verified_at' => Carbon::now(),
                'email' => 'beka@powershare.fund',
                'password' => 'QeciGaiqca!',
                'role_id' => 1
            ],
            [
                'name' => 'დავით სვიმონიშვილი',
                'email_verified_at' => Carbon::now(),
                'email' => 'david@powershare.fund',
                'password' => 'QeciGaiqca!',
                'role_id' => 1
            ],
            [
                'name' => 'ილია გოგოჭური',
                'email_verified_at' => Carbon::now(),
                'email' => 'igogo17@freeuni.edu.ge',
                'password' => 'QeciGaiqca!',
                'role_id' => 1
            ],
            [
                'name' => 'ანა მიქათაძე',
                'email_verified_at' => Carbon::now(),
                'email' => 'ana@powershare.fund',
                'password' => 'QeciGaiqca!',
                'role_id' => 1
            ],
            [
                'name' => 'ნორმალური ადამიანი!',
                'email_verified_at' => Carbon::now(),
                'email' => 'user@powershare.fund',
                'password' => 'QeciGaiqca!',
                'role_id' => 2
            ]
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
    }
}
