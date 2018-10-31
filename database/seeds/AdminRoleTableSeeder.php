<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        DB::table('admin_role')->insert([
            ['admin_id' => 1, 'role_id' => 1,'created_at'=> $now, 'updated_at'=> $now],
        ]);
    }
}
