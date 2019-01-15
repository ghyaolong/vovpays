<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankinfoToWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {

            //添加银行卡信息相关字段
            $table->string('accountName')->comment('银行开户名');
            $table->string('bankCardNo')->comment('银行卡号');
            $table->string('branchName')->comment('银行支行名');
            $table->string('bankCode')->comment('银行编码');
            $table->string('orderId')->comment('结算单流水号');
            $table->string('outOrderId')->nullable()->comment('商户侧提交结算单号');
            $table->string('upOrderId')->nullable()->comment('上游结算单号');
            $table->string('channelCode')->comment('结算通道编码');
            $table->string('comment')->nullable()->comment('结算备注信息');
            $table->json('extend')->nullable()->comment('扩展银行卡信息,json格式');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            //
            $table->dropColumn('accountName');
            $table->dropColumn('bankCardNo');
            $table->dropColumn('branchName');
            $table->dropColumn('bankCode');
            $table->dropColumn('orderId');
            $table->dropColumn('outOrderId');
            $table->dropColumn('upOrderId');
            $table->dropColumn('channelCode');
            $table->dropColumn('comment');
            $table->dropColumn('extend');
        });
    }
}
