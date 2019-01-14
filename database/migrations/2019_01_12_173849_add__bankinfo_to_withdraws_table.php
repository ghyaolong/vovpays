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
            //
            $table->string('accountName')->comment('银行开户名');
            $table->string('bankCardNo')->comment('银行卡号');
            $table->string('branchName')->comment('银行支行名');
            $table->unsignedInteger('bank_code')->comment('银行编码');
            $table->string('extend')->comment('扩展银行信息json格式');

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
            $table->dropColumn('bank_code');
            $table->dropColumn('extend');
        });
    }
}
