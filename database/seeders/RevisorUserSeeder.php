<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RevisorUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'revisor@email.com'], // Controlla se esiste già
            [
                'name' => 'Revisore',
                'password' => Hash::make('password'),
                'is_revisor' => true,
            ]
        );
    }
}
