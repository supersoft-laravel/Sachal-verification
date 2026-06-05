<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CoordinatorUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->where('email', 'coordinator@sachal.com')->delete();

        DB::table('users')->insert([
            'name'       => 'Coordinator',
            'email'      => 'coordinator@sachal.com',
            'password'   => Hash::make('coordinator123'),
            'role'       => 'coordinator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
