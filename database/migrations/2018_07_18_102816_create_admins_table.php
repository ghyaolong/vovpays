<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('email',20)->unique()->comment('邮箱');
            $table->string('phone',11)->unique()->comment('手机号');
            $table->string('verify',6)->nullable()->comment('验证码');
            $table->boolean('status')->default(1)->comment('账号状态');
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
        Schema::dropIfExists('admins');
    }
}
