<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Site
 * 
 * @property int $id
 * @property string $domain
 * @property string $display_name
 * @property string $url
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 *
 * @package App\Models
 */
class Site extends Model
{
	protected $table = 'site';

	protected $fillable = [
		'domain',
		'display_name',
		'url'
	];
}
