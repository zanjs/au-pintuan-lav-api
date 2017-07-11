<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('index')->notNull()->comment('索引');
            $table->string('group_id')->notNull()->comment('所属团');
            $table->string('user_id')->notNull()->comment('用户id');
            $table->string('alias')->default(null)->comment('花名');
            $table->string('avatar')->default(null)->comment('头像');
            $table->string('comment')->default(null)->comment('备注说明');
            $table->string('product_comment')->default(null)->comment('产品说明');
            $table->string('phone')->nullable()->default(null)->comment('联系电话');
            $table->string('address')->nullable()->default(null)->comment('联系地址');
            $table->string('location_address')->nullable()->default(null)->comment('定位地址');
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
        Schema::dropIfExists('comments');
    }
}
