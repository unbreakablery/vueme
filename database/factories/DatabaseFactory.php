<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/**
 * Create Users
 * @param Faker $faker
 * @return array
 */

$factory->define(
    User::class, function (Faker $faker) {
    return [
        'site_id' => 1,
        'role_id' => 1,
        'email' => $faker->email,
        'email_validated' => 1,
        'email_risky' => 0,
        'password' => Hash::make('comeasyouare'),
        'account_status' => 'ACTIVE',
        'credits' => 0,
    ];
});

/**
 * Create User Profile
 * @param Faker $faker
 * @param $attributes
 * @return array
 */
$factory->define(
    \App\Models\UserProfile::class, function (Faker $faker, $attributes) {
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'user_id' => $attributes['user_id'],
        'display_name' => $faker->name
    ];
});


/**
 * Create File
 * @param Faker $faker
 * @return array
 */
$factory->define(
    \App\Models\File::class, function (Faker $faker, array $params = []) {
    return [
        'name' => $params['name'],
        'path' => $params['path'],
        'ext' => 'png'
    ];
});

/**
 * Create Reviews
 * @param Faker $faker
 * @return array
 */
$factory->define(
    \App\Models\Review::class, function (Faker $faker, array $params = []) {
    return [
        'user_id' => $params['user_id'],
        'psychic_id' => $params['user_id'],
        'title' => $faker->text(40),
        'text' => $faker->text(3000),
        'rating' => $faker->numberBetween(0, 5)
    ];
});

/**
 * Create Credentials
 * @param Faker $faker
 * @return array
 */
$factory->define(
    \App\Models\UserCredentials::class, function (Faker $faker, array $params = []) {
    return [
        'user_id' => $params['user_id'],
        'institution_name' => $faker->jobTitle,
        'from_year' => $faker->year(),
        'to_year' => $faker->year(),
        'degree' => $faker->title,
        'area_of_study' => $faker->text,
        'description' => $faker->text(500),

    ];
});

/**
 * Create User Services
 * @param Faker $faker
 * @return array
 */
$factory->define(
    \App\Models\UserService::class, function (Faker $faker, array $params = []) {
    return [
        'user_id' => $params['user_id'],
        'service_id' => $params['service_id'],
        'rate' => rand(1, 100),
        'min_duration' => rand(1, 10),
        'active' => 1

    ];
});

/**
 * Create User Shedule
 * @param Faker $faker
 * @return array
 */
$factory->define(
    \App\Models\UserSchedule::class, function (Faker $faker, array $params = []) {
    return [
        'user_id' => $params['user_id'],
        'day' => $faker->dayOfWeek,
        'active' => 1,
        'from' => $faker->time(),
        'till' => $faker->time(),

    ];
});
