<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@aulabpost.test',
                'name' => 'Admin',
                'is_admin' => true,
                'is_revisor' => false,
                'is_writer' => false,
                'is_owner' => false,
            ],
            [
                'email' => 'revisor@aulabpost.test',
                'name' => 'Revisor',
                'is_admin' => false,
                'is_revisor' => true,
                'is_writer' => false,
                'is_owner' => false,
            ],
            [
                'email' => 'writer@aulabpost.test',
                'name' => 'Writer',
                'is_admin' => false,
                'is_revisor' => false,
                'is_writer' => true,
                'is_owner' => false,
            ],
            [
                'email' => 'owner@aulabpost.test',
                'name' => 'Owner',
                'is_admin' => false,
                'is_revisor' => false,
                'is_writer' => false,
                'is_owner' => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                array_merge($user, ['password' => Hash::make('password')])
            );
        }
    }
}
