<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role',['member', 'admin', 'support', 'reviewer', 'admin_team_member','team_member'])->default('member');
            $table->string('token')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('subscription_is_active')->default(false);
            $table->integer('added_by')->nullable();
            $table->integer('edited_by')->nullable();
            $table->integer('admin_id')->nullable();
            $table->string('account_type')->nullable();
            $table->string('uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('token');
            $table->dropColumn('is_active');
            $table->dropColumn('subscription_is_active');
            $table->dropColumn('added_by');
            $table->dropColumn('edited_by');
            $table->dropColumn('admin_id');
            $table->dropColumn('account_type');
            $table->dropColumn('uuid');
        });
    }
}
