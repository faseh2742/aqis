<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'firstName' => 'Ajlal',
            'lastName' => 'Haider',
            'username' => 'ajlal.haider',
            'email' => 'ajlalhaider13@gmail.com',
            'password' => Hash::make('secret'),
            'role_id' => 3,
            'active' => 1,
        ]);
    }
}
