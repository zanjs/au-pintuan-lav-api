<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_id',50)->notNull()->comment('所属团编号');
            $table->string('name',100)->default(null)->comment('商品名称');
            $table->decimal('price',12,2)->default(0.00)->comment('商品价格');
            $table->integer('quantity')->nullable()->default(null)->comment('商品数量');
            $table->integer('sell')->nullable()->default(0)->comment('售出数量');
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
        Schema::dropIfExists('products');
    }
}
