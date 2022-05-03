<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWhitelabelConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whitelabel_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            // $table->string('workspace_id')->nullable();
            $table->string('domain')->nullable();
            $table->string('color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('support_url')->nullable();
            $table->string('email')->nullable();
            $table->text('welcome_mail')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_from_name')->nullable();

            // $table->string('app_secret')->nullable();
            // $table->string('app_id')->nullable();
            $table->text('app_name')->nullable();


            $table->enum('encryption', ['none', 'ssl', 'tls'])->default('none');
            $table->string('mail_from_address')->nullable();
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
        Schema::dropIfExists('whitelabel_configs');
    }
}
