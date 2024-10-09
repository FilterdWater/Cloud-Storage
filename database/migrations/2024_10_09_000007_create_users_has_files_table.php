<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersHasFilesTable extends Migration
{
    public function up(): void
    {
        Schema::create('users_has_files', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('files_id')->constrained('files')->onDelete('cascade');
            $table->primary(['users_id', 'files_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_has_files');
    }
};
