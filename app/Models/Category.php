<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
class Category extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $table = 'category';

	protected $fillable = [
		'name', 'color'
	];

    protected $with = ['image'];

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_category');					
	}

	public function users_activos($id)
	{

		$services = DB::table('user_service')
            ->select('user_id')
            ->where('active', true)
            ->groupby("user_id")
            ->pluck('user_id')
            ->toArray();
		$data = DB::table('user_category')->select(DB::Raw("user_category.user_id"))
		->leftJoin("user","user_category.user_id","user.id")
		->leftJoin("user_profile","user_category.user_id","user_profile.user_id")
			->leftJoin("user_service","user_category.user_id","user_service.user_id")
			->where("user_category.category_id", "=", $id)
			->wherein("user_profile.user_id",  $services)
			->where("user_service.active", "=", TRUE)
			->where("user.email_validated", "=", 1)
			->where("user.fraud", "=", 0)
			->where("user.account_status", "=", "ACTIVE")
			->where("user.test_user", "=", 0)
			->where("user.profile_percent", "!=", 0)
			->distinct()->get();

		return count($data);					
	}

    public function image()
    {
        return $this->morphOne('App\Models\File', 'fileable');
    }

}
