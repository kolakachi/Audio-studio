<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_books', function (Blueprint $table) {
            $table->string('uuid')->nullable();
            $table->string('audio_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_books', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('audio_path');

        });
    }
}
