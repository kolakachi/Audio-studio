<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStoredAudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('file_name')->nullable();
            $table->string('category')->nullable();
            $table->string('file_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audios');
    }
}
