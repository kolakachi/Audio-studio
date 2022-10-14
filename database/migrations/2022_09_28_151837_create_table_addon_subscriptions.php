<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAddonSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addon_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subscription_id');
            $table->string('name')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->integer('limit')->nullable();
            $table->boolean('status')->default(0);
            $table->enum('type', ['monthly', 'lifetime', 'yearly'])->default('lifetime');
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
        Schema::dropIfExists('addon_subscriptions');
    }
}
