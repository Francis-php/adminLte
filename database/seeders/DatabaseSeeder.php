<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create(['name' => 'user']);
        Role::factory()->create(['name' => 'admin']);

         User::factory()->create([
             'first_name' => 'Admin',
             'last_name' => 'Base',
             'email' => 'admin@atis.al',
             'password' => '12345password@',
             'gender' => 'other',
             'type' => '2',
         ]);
    }
}
