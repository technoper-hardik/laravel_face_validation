<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Normal User']);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@123456'),
        ])->each(function ($user) {
            $user->assignRole('Admin');
        });

        User::factory(10)->create([
            'password' => bcrypt('user@123456'),
        ])->each(function ($user) {
            $user->assignRole('Normal User');
        });
    }
}
