<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'role' => 'admin',
            'unique_number' => 1252365101,
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
