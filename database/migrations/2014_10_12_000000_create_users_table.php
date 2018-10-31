<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',30)->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('email',30)->comment('邮箱');
            $table->string('phone',11)->nullable()->comment('电话号码');
            $table->unsignedTinyInteger('group')->default(1)->comment('用户组表示,1用户，2代理商');
            $table->unsignedInteger('parentId')->default(0)->comment('归属代理ID');
            $table->decimal('balance',11,2)->default(0)->comment('余额');
            $table->decimal('freezeBalance',11,2)->default(0)->comment('冻结金额');
            $table->string('PaymentPassword')->comment('支付密码');
            $table->string('merchant',10)->unique()->comment('商户号');
            $table->string('apiKey')->unique()->comment('密钥');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态：0禁用，1启用');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
