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
            'name'  => 'add_account_type',
            'value' => '1',
            'remark'=> '挂号方式:1商户后台挂号,2总后台挂号',
            'created_at'=> $now,
            'updated_at'=> $now
        ]);
    }
}
