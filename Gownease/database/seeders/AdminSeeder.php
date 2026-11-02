<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gownease.test'],
            [
                'name' => 'GownEase Administrator',
                'password' => Hash::make(
                    env('GOWNEASE_ADMIN_PASSWORD', 'ChangeMe123!')
                ),
                'role' => 'admin',
            ]
        );
    }
}
