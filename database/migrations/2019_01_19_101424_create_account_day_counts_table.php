<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAccountDayCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_day_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account')->comment('账号');
            $table->unsignedInteger('user_id')->comment('账号拥有者id');
            $table->decimal('account_amount',11,2)->default(0)->comment('账号单日成功交易金额');
            $table->unsignedInteger('account_order_count')->default(0)->comment('账号单日订单量');
            $table->unsignedInteger('account_order_suc_count')->default(0)->comment('account_order_suc_count');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at');
        });
        DB::statement("ALTER TABLE `pay_account_day_counts` comment '账号订单单日统计'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_day_counts');
    }
}
