<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class EmailAdminConfig extends Model
{
	protected $table = 'email_admin_config';

    protected $hidden = ["created_at", "updated_at"];

    protected $fillable = [
        'emails',
        'subject',
        'date',
        'timezone',
        'type',
        'users'
    ];

    protected $casts = [
        'users' => 'array'
    ];

}
