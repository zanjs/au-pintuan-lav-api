<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_id')->notNull()->comment('所属团');
            $table->string('alias')->default(null)->comment('花名');
            $table->string('avatar')->default(null)->comment('头像');
            $table->string('comment')->default(null)->comment('备注说明');
            $table->string('products')->default(null)->comment('产品信息');
            $table->text('products_desc')->default(null)->comment('产品订单描述');
            $table->string('phone')->default(null)->comment('联系电话');
            $table->string('address')->default(null)->comment('联系地址');
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
        Schema::dropIfExists('orders');
    }
}
