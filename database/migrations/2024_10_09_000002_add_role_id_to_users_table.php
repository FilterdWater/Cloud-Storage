<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the role_id foreign key
            $table->foreignId('role_id')
            ->default(2)
            ->after('id')
            ->constrained('roles')
            ->onUpdate('cascade') // If the role_id in the roles table is updated, it cascades to the users table
            ->onDelete('restrict'); // Prevents deletion of the role if any user is assigned to it
        });
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
}
