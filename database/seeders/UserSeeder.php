<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin seeder
        User::create([
            'name' => 'Admin User',
            'email' => 'windaadmin@gmail.com',
            'password' => bcrypt('bintangrm'),
            'role' => 'admin',
        ]);

        // manager seeder
        User::create([
            'name' => 'Manager User',
            'email' => 'mandamanager@gmail.com',
            'password' => bcrypt('bintangrm'),
            'role' => 'manager',
        ]);
    }
}
