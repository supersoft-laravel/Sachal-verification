<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Avoid duplicate — delete existing admin with same email first
        DB::table('users')->where('email', 'admin@sachal.com')->delete();

        DB::table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@sachal.com',
            'password'   => Hash::make('admin123'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
