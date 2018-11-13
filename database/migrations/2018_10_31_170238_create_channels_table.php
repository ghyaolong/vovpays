<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {

            $table->increments('id');
            $table->string('merchant')->nullable()->comment('上游商户号');
            $table->string('signkey')->nullable()->comment('上游密钥');
            $table->string('channelName',30)->comment('通道名称');
            $table->string('channelCode',20)->comment('通道编码');
            $table->string('payGateway')->comment('支付网关地址');
            $table->string('searchUrl')->comment('查询网关地址');
            $table->decimal('runRate',9,6)->default(0)->comment('运营费率');
            $table->decimal('costRate',9,6)->default(0)->comment('成本费率');
            $table->string('refererDomain',20)->nullable()->comment('防封域名');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态:0禁用，1启用，2删除');
            $table->unsignedTinyInteger('planType')->default(0)->comment('结算方式：0：T+0，1：T+1');
            $table->unsignedInteger('channelQuota')->default(0)->comment('通道限额：0不限额');
            $table->decimal('tradeAmount')->default(0)->comment('交易成功金额');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `pay_channels` comment '通道表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
