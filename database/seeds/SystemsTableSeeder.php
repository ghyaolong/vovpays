<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        DB::table('systems')->insert([
                ['name' => 'add_account_type', 'value' => '1', 'remark' => '挂号方式:1商户后台挂号,2总后台挂号,3代理后台挂号,4三方挂号', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'withdraw_permission_type', 'value' => 'PASSWORD', 'remark' => '提现验证方式: SMS短信验证,PASSWORD密码验证,GOOGLE谷歌验证', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'withdraw_downline', 'value' => '100', 'remark' => '提款最少金额(单位元)', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'withdraw_fee_type', 'value' => 'FIX', 'remark' => '提款收费类型:RATE百分比,FIX固定金额', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'withdraw_rate', 'value' => '1', 'remark' => '提款收费配置值', 'created_at' => $now, 'updated_at' => $now],
            ]
        );
    }
}
