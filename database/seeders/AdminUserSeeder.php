<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@satujiwa.my'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@256511'),
                'role' => 'admin',
            ]
        );
    }
}
