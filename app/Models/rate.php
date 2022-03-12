<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rate
 * 
 * @property int $id
 * @property int $user_id
 * @property float $receive_sms
 * @property float $send_sms
 * @property float $receive_mms
 * @property float $send_mms
 * @property float $voice_minute
 * @property int $voice_minute_min
 * @property float $create_network
 * @property float $ppm_stream
 * @property float $ppv_stream
 * @property float $recorded_stream
 * @property float $video_chat_minute
 * @property float $bulletin
 * @property int $vchat_1_1_minimum_duration
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property float $vchat11
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Rate extends Model
{
	protected $table = 'rate';

	protected $casts = [
		'user_id' => 'int',
		'receive_sms' => 'float',
		'send_sms' => 'float',
		'receive_mms' => 'float',
		'send_mms' => 'float',
		'voice_minute' => 'float',
		'voice_minute_min' => 'int',
		'create_network' => 'float',
		'ppm_stream' => 'float',
		'ppv_stream' => 'float',
		'recorded_stream' => 'float',
		'video_chat_minute' => 'float',
		'bulletin' => 'float',
		'vchat_1_1_minimum_duration' => 'int',
		'vchat11' => 'float'
	];

	protected $fillable = [
		'user_id',
		'receive_sms',
		'send_sms',
		'receive_mms',
		'send_mms',
		'voice_minute',
		'voice_minute_min',
		'create_network',
		'ppm_stream',
		'ppv_stream',
		'recorded_stream',
		'video_chat_minute',
		'bulletin',
		'vchat_1_1_minimum_duration',
		'vchat11'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
