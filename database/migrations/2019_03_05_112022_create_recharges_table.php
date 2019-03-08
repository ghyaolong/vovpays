<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('商户id');
            $table->decimal('recharge_amount',20,2)->default(0)->comment('充值金额');
            $table->string('merchant')->comment('商户号');
            $table->decimal('actual_amount',20,2)->default(0)->comment('实付金额');
            $table->string('orderNo')->comment('系统单号');
            $table->string('orderMk')->nullable()->comment('固码备注');
            $table->unsignedTinyInteger('pay_status')->default(0)->comment('订单状态：0未支付，1已支付，3异常');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `pay_recharges` comment '充值表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recharges');
    }
}
