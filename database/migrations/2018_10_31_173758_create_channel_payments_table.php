<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateChannelPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('channel_id')->comment('通道id');
            $table->string('paymentName',30)->comment('支付名称');
            $table->string('paymentCode',10)->comment('支付编码');
            $table->string('ico')->nullable()->comment('支付方式logo');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态：0关闭，1启用');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `pay_channel_payments` comment '支付方式配置表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_payments');
    }
}
