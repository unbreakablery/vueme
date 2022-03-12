<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user)
            $user->save();
        return;
        $emails =['psychic@example.com','user@example.com','admin@example.com'];
        for($i=0 ; $i < 3; $i++){
            DB::table('user')
                ->insert([
                    'email' => $emails[$i].'@example.com',
                    'password' => bcrypt('11111111'),
                    'role_id' => $i+1,

                ]);

        }
        for($i=0 ; $i < 3; $i++){

            $names =['PsychicName','UserName','AdminName'];
            $lastNames =['PsychicLastName','UserLastName','AdminLastName'];
            $descriptions =['Model Description','User Description','Admin Description'];
            DB::table('user_profile')
                ->insert([
                    'name' => $names[$i],
                    'last_name' => $lastNames[$i],
                    'description' =>  $descriptions[$i],
                    'user_id' => $i+1,

                ]);
        }
        for($i=0 ; $i < 3; $i++){
            DB::table('user_category')
                ->insert([
                    'user_id' => $i+1,
                    'category_id' => $i+1,

                ]);

        }
    }
}
