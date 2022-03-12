<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Log as log;
use Carbon\Carbon;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Services\NotificationsInAppUtils;


/**
 * Class User
 * 
 * @property int $id
 * @property int $site_id
 * @property int $role_id
 * @property string $email
 * @property string $name
 * @property string $last_name
 * @property string $display_name
 * @property string $country_code
 * @property int $email_validated
 * @property int $email_risky
 * @property string $password
 * @property string $account_status
 * @property int $credits
 * @property string $remember_token
 * @property int $test_user
 * @property \Carbon\Carbon $status_calls
 * @property \Carbon\Carbon $accepted_terms
 * @property string $content_level
 * @property \Carbon\Carbon $birth_date
 * @property \Carbon\Carbon $app_used_at
 * @property \Carbon\Carbon $last_log_in
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\Role $role
 * @property \Illuminate\Database\Eloquent\Collection $media
 * @property \Illuminate\Database\Eloquent\Collection $notify_in_apps
 * @property \Illuminate\Database\Eloquent\Collection $posts
 * @property \Illuminate\Database\Eloquent\Collection $rates
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
 * @property \Illuminate\Database\Eloquent\Collection $categories
 * @property \Illuminate\Database\Eloquent\Collection $specialties
 * @property \Illuminate\Database\Eloquent\Collection $user_credit_logs
 * @property \Illuminate\Database\Eloquent\Collection $user_message_logs
 * @property \Illuminate\Database\Eloquent\Collection $user_mobile_nums
 * @property \Illuminate\Database\Eloquent\Collection $user_subscriptions
 *
 * @package App\Models
 */
class UserHoroscope extends  Model
{
    protected $table = 'user_horoscope';

	protected $fillable = [
		'email',
		'email_validated',
		'email_risky',
		'birth_date',
		'name',
        'country_code',
        'number',
	];



}
