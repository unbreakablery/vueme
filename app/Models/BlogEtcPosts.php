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
use Illuminate\Support\Facades\DB;

class BlogEtcPosts extends Model
{
	protected $casts = [
        'user_id' => 'int',
    ];

    protected $dates = [
        'posted_at',
    ];

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'subtitle',
        'post_body',
        'use_view_file',
        'is_published',
        'image_large',
        'image_medium',
        'image_thumbnail',
        'posted_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function next()
    {
        return (BlogEtcPosts::where('id', '<', $this->id)->where('is_published', 1)->latest()->first())->slug ?? false;

    }
    public function prev()
    {
        return (BlogEtcPosts::where('id', '>', $this->id)->where('is_published', 1)->first())->slug ?? false;
    }
	// use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'blog_etc_posts';


	public function Categories()
	{
		
		return DB::table('blog_etc_post_categories')
				->select('blog_etc_categories.category_name as name', 'blog_etc_categories.slug')
				->join('blog_etc_categories','blog_etc_post_categories.blog_etc_category_id' , '=',  'blog_etc_categories.id')
				->where('blog_etc_post_categories.blog_etc_post_id', '=', $this->id)
				->get();

	}

}
