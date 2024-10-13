<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the specific seeders
        $this->call([
            UserSeeder::class,
            FileSeeder::class,
        ]);
    }
}
