<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all user IDs from the 'users' table
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Loop 200 times to create 200 fake files
        for ($i = 0; $i < 200; $i++) {
            DB::table('files')->insert([
                'path' => 'uploads/' . $faker->word() . '/' . $faker->uuid() . '.pdf',  // Random file path
                'user_id' => $faker->randomElement($userIds),  // Assign a random user ID
                'created_at' => $faker->dateTimeBetween('-1 years', 'now'), // Random creation time
                'updated_at' => now(),  // Set to current time
                'deleted_at' => $faker->optional(0.1)->dateTimeBetween('-6 months', 'now'), // Randomly set deleted_at (10% chance of deletion)
            ]);
        }
    }
}
