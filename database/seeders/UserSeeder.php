<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->delete();
        \DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
        \DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'test-admin',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('hogehoge')
        ]);
        \DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'test-owner',
            'email' => 'owner@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('hogehoge')
        ]);
    }
}
