<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',50)->notNull()->comment('用户ID');
            $table->string('user_name')->default(null)->comment('用户昵称');
            $table->string('open_id')->default(null)->comment('微信用户的id');
            $table->string('ip')->default(null)->comment('ip地址');
            $table->string('device')->default(null)->comment('用户设备信息');
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
        Schema::dropIfExists('login_logs');
    }
}
