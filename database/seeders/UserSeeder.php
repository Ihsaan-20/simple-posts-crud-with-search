<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ihsaan',
            'email' => 'ihsan@gmail.com',
            'password' => Hash::make(1234),
        ]);

        User::create([
            'name' => 'Asnan',
            'email' => 'asnan@gmail.com',
            'password' => Hash::make(1234),
        ]);

        User::create([
            'name' => 'Azaan',
            'email' => 'azaan@gmail.com',
            'password' => Hash::make(1234),
        ]);

        User::create([
            'name' => 'Kashif',
            'email' => 'kashif@gmail.com',
            'password' => Hash::make(1234),
        ]);
    }
}
