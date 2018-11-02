<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('商户id');
            $table->string('bankName',40)->comment('银行名称');
            $table->decimal('withdrawAmount',11,2)->default(0)->comment('提现金额');
            $table->decimal('withdrawRate',6,2)->default(0)->comment('提现手续费');
            $table->decimal('toAmount',11,2)->default(0)->comment('到账金额');
            $table->unsignedTinyInteger('status')->default(0)->comment('体现状态：0未处理，1处理中，2已结算，3已取消');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `pay_withdraws` comment '提现记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
}
