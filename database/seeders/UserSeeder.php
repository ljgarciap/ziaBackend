<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@zia.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@zia.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@zia.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}
