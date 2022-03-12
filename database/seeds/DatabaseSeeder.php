<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Models\User::all() as $user){

            /**
             * Create User Shedule
             */
            factory(\App\Models\UserSchedule::class, 6)->create(['user_id' => $user->id]);

            /**
             * Add Favorites
             */
            $user->favorites()->saveMany(
                \App\Models\User::orderByRaw('RAND()')->where('id', '!=', $user->id)->take(10)->get()
            );
            /**
             * Create UserCredentials
             */
            factory(\App\Models\UserCredentials::class, 1)->create(['user_id' => $user->id]);

            /**
             * Create User Service
             */
            foreach (\App\Models\Services::all() as $service)
              factory(\App\Models\UserService::class, 1)->create(['user_id' => $user->id, 'service_id' => $service->id]);

        }
//        return;


//        for($i = 0; $i < 50; $i++) {
//            factory(\App\Models\File::class, 1)->create(['path' => "$i.png", 'name' => $i]);
//        }
//
//        $files = \App\Models\File::all();

        \App\Models\Category::all()->each(function ($category, $key) use ($files) {

//            if (isset($files[$key])) {
//                $category->imagen()->save($files[$key]);
//                $category->save();
//            }

            for($i = 0; $i < 20; $i++){
                factory(\App\Models\User::class, 1)->create()->each(function ($user) use ($category) {

                    $category->users()->save($user);

                    factory(\App\Models\UserProfile::class, 1)->create(['user_id' => $user->id]);

                    factory(\App\Models\Review::class, 10)->create(['user_id' => $user->id]);
                });
            }
        });
    }
}
