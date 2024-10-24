<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the role_id foreign key
            $table
                ->foreignId('role_id')
                ->default(2)
                ->after('id')
                ->constrained('roles')
                ->onUpdate('cascade') // If the role_id in the roles table is updated, it cascades to the users table
                ->onDelete('restrict'); // Prevents deletion of the role if any user is assigned to it
        });

        // Insert test users only if "APP_ENV=production" inside the .env file
        if (!app()->environment('production')) {
            DB::table('users')->insert([
                [
                    'name' => 'Admin User',
                    'email' => 'admin@admin.com',
                    'password' => Hash::make('zxcasdqwe'),
                    'role_id' => 1, // Assuming 'Admin' role has an ID of 1
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Regular User',
                    'email' => 'user@user.com',
                    'password' => Hash::make('zxcasdqwe'),
                    'role_id' => 2, // Assuming 'User' role has an ID of 2
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key if rolling back
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
