<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment('拼团标题');
            $table->text('description')->notNull()->comment('拼团描述');
            $table->integer('type_id')->notNull()->comment('拼团类型');
            $table->string('head_id',50)->notNull()->comment('团长ID');
            $table->string('alias')->default(null)->comment('团长花名');
            $table->string('avatar')->default(null)->comment('团长头像');
            $table->string('qr_code')->nullable()->default(null)->comment('二维码内容');
            $table->string('qr_code_path')->nullable()->default(null)->comment('二维码地址路径');
            $table->text('image')->nullable()->default(null)->comment('上传的图片');
            $table->integer('open')->default(1)->comment('接龙状态 1 为接龙中 2 已截止');
            $table->string('currency_id',50)->nullable()->default(null)->comment('货币类型ID');
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
        Schema::dropIfExists('groups');
    }
}
