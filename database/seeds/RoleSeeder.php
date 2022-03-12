<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['horoscope'];
        for($i=0 ; $i < count($roles); $i++){
            DB::table('role')
                ->insert(['name'=>$roles[$i]]);
        }
    }
}
