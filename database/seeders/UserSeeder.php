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
        $user = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@gmail.com',
        ]);

        $user->assignRole('Admin');

        $manager = User::factory()->create([
            'name' => 'Test Manager',
            'email' => 'manager@gmail.com',
        ]);

        $manager->assignRole('Manager');
    }
}
