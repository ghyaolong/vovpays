<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleRuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        DB::table('role_rule')->insert([
            ['role_id' => 1, 'rule_id' => 2,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 3,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 4,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 5,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 6,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 7,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 8,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 9,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 10,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 11,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 12,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 13,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 14,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 15,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 16,'created_at'=> $now, 'updated_at'=> $now],
            ['role_id' => 1, 'rule_id' => 17,'created_at'=> $now, 'updated_at'=> $now],
        ]);
    }
}
