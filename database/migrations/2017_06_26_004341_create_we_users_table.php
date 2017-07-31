<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('we_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('open_id')->unique();
            $table->string('nickname');
            $table->string('avatar');
            $table->string('u_name',50)->nullable()->default(null)->comment('跟团名字');
            $table->string('u_phone',50)->nullable()->default(null)->comment('跟团电话');
            $table->string('u_wechat',50)->nullable()->default(null)->comment('跟团微信');
            $table->string('u_address',250)->nullable()->default(null)->comment('跟团地址');
            $table->rememberToken();
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
        Schema::dropIfExists('we_users');
    }
}
