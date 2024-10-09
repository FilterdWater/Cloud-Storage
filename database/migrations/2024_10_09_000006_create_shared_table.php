<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedTable extends Migration
{
    public function up()
    {
        Schema::create('shared', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onUpdate('cascade')->onDelete('restrict');
            $table->string('owner_email', 45);
            $table->string('recipient_email', 45);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shared');
    }
}
