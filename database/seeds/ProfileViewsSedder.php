<?php

use Illuminate\Database\Seeder;

class ProfileViewsSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        for($i=0 ; $i < 30; $i++){
            DB::table('profile_views')
                ->insert(['psychic_id'=>1]);
        }
    }
}
