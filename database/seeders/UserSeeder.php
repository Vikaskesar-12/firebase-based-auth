<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
{
    User::insert([
    [
        'user_id' => 1,
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'role' => 'admin',
        'password' => Hash::make('password123')
    ],
    [
        'user_id' => 2,
        'name' => 'Normal User',
        'email' => 'user@example.com',
        'role' => 'user',
        'password' => Hash::make('password123')
    ],
]);

}
}


