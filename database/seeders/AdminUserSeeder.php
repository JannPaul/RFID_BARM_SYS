<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['employeeid' => 'admin'],
            [
                'firstname'    => 'System',
                'lastname'     => 'Administrator',
                'employeeid'   => 'admin',
                'email'        => 'admin@example.com',
                'password'     => Hash::make('admin123'),
                'access_level' => 'admin',
                'status'       => 'active',
            ]
        );
    }
}