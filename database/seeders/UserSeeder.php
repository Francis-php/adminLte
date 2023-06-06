<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users= User::all();
        $faker = Faker::create();

        foreach ($users as $user){
            $names= explode(' ', $user->name);

            DB::table('users')->where('id',$user->id)->update([
                'first_name' => $names[0],
                'last_name' => $names[1],
                'gender' => $faker->randomElement(['male', 'female', 'other']),
            ]);
        }

    }
}
