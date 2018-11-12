<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateOrderDayCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_day_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->unsignedInteger('agent_id')->comment('代理id');
            $table->decimal('amount')->default(0)->comment('商户单日订单成功金额');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `pay_order_day_counts` comment '用户单日订单成功金额统计表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_day_counts');
    }
}
