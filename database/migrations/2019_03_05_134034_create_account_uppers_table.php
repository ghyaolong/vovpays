<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountUppersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_uppers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->comment('账号id');
            $table->text('privatekey')->comment('私钥');
            $table->text('publikey')->comment('公钥');
            $table->string('signkey')->comment('加密key');
            $table->unsignedInteger('channel_id')->comment('通道id');
            $table->unsignedInteger('channel_payment_id')->comment('支付方式id');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态：0禁用。1启用');
            $table->unsignedInteger('num')->comment('订单量 ');
            $table->unsignedInteger('dayQuota')->default(0)->comment('限额');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::statement("ALTER TABLE `pay_account_uppers` comment '上游账号配置表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_uppers');
    }
}
