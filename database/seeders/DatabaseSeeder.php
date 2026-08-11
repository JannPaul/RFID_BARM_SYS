<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['employeeid' => 'admin'],
            [
                'firstname' => 'System',
                'lastname' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'access_level' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Books and book copies
        $this->call([
            BookSeeder::class,
        ]);
    }
}