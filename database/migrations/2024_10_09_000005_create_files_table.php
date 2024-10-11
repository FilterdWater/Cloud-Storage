<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255);        // Adjust the size for file paths (more than 45 characters)
            $table->foreignId('user_id')        // Add the user_id column
                ->constrained('users')          // Reference the id column in the users table
                ->onUpdate('cascade')           // Cascade updates to the user_id in the files table
                ->onDelete('cascade');          // Cascade delete to remove files when the associated user is deleted
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
