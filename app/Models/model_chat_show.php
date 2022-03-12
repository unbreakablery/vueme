<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use DB;
use Log;

use App\user_credit_log;
use App\star_chat_show_media;

class model_chat_show extends Model {

    protected $table = 'model_chat_show';
    protected $fillable = ['model_id', 'show_type', 'title', 'description', 'hashtags', 'credits_price', 'started_at', 'ended_at', 'notify_email_at', 'notify_sms_at', 'notify_sns_at'];
    protected $appens = ['thumbnail_image'];
    const TIME_TIL_ABORT = 300; //5min
    const CACHE_MIN = 60;
	//

    public static function boot() {
        parent::boot();

        static::created(function($star_chat_show) {
            self::_set_current_show_cache($star_chat_show->star_id, $star_chat_show);
            return true;
        });
        static::updated(function($star_chat_show) {
            self::_reset_current_show_cache($star_chat_show->star_id);
            return true;
        });
        static::deleted(function($star_chat_show) {
            self::_reset_current_show_cache($star_chat_show->star_id);
            return true;
        });
    }

    private static function _get_current_show_cache_key($star_id) {
        return 'app:star_chat_show:get_current_show('.$star_id.')';
    }


    public function getThumbnailImageAttribute() {
        $baseUrl = $this->base_url();
        $streamName = $this->stream_name('all');
        $streamName = str_replace('ngrp:', '', $streamName);
        $streamName = str_replace('_all', '', $streamName);
        return 'https://'.$baseUrl.'/thumbnail?application=live&streamname='.$streamName.'&format=jpeg&size=360x640';
    }

    public static function get_current_show($star_id) {
        $cache_key = self::_get_current_show_cache_key($star_id);
        try {
            $star_chat_show = \CacheUtils::get($cache_key);
        } catch (Exception $e) {
            $star_chat_show = null;
        }
        if (!isset($star_chat_show)) {
            $star_chat_show = self::_reset_current_show_cache($star_id);
        }
        return $star_chat_show;
    }

    private static function _get_current_show($star_id) {
        $star_chat_show = model_chat_show::where('star_id', '=', $star_id)
            ->where('ended_at', '=', '0000-00-00 00:00:00')
            ->orderBy('created_at', 'DESC')
            ->useWritePdo()
            ->first();
        if (!$star_chat_show) {
            $star_chat_show = false;
        }
        return $star_chat_show;
    }

    private static function _set_current_show_cache($star_id, $star_chat_show) {
        $cache_key = self::_get_current_show_cache_key($star_id);
        \CacheUtils::put($cache_key, $star_chat_show, self::CACHE_MIN);
    }

    private static function _reset_current_show_cache($star_id) {
        $star_chat_show = self::_get_current_show($star_id);
        self::_set_current_show_cache($star_id, $star_chat_show);
        return $star_chat_show;
    }

    public static function duration($input) {
        $query = model_chat_show::query();
        if (!empty($input['star_id'])) {
            $query->where('star_id', '=', $input['star_id']);
        }
        if (!empty($input['day'])) {
            $query->where('created_at', '>=', $input['day'].' 00:00:00')
                ->where('created_at', '<=', $input['day'].' 23:59:59');
        }
        $star_chat_shows = $query->get();
        if (!count($star_chat_shows)) {
            return 0;
        }
        $total_duration = 0;
        foreach ($star_chat_shows as $scs) {
            if ($scs->ended_at != '0000-00-00 00:00:00') {
                $total_duration += (strtotime($scs->ended_at) - strtotime($scs->started_at));
            } else {
                $total_duration += time() - strtotime($scs->started_at);
            }
        }
        return $total_duration;
    }

    public function model(){
        return $this->belongsTo('App\User');
    }

    public static function start_show($input) {
        if (!isset($input['star']) || !isset($input['type'])) {
            return false;
        }
        if (model_chat_show::get_current_show($input['star']->id)) {
            return false;
        }

        $star_rate = star_rate::get_current_rate($input['star']->id);
        $credits_price = 0;
        if ($input['type'] == 'PAY_PER_VIEW') {
            $credits_price = $star_rate->ppv_stream;
        } else if ($input['type'] == 'PAY_PER_MINUTE') {
            $credits_price = $star_rate->ppm_stream;
        } else if ($input['type'] == 'FREE') {
            $sponsor = star_sponsor::where('star_id', '=', $input['star']->id)
                ->where('status', '=', 'ACTIVE')
                ->first();
            if (!$sponsor) {
                return false;
            }
        } else if ($input['type'] == 'GIFT') {
            $gift = star_gift::where('star_id', '=', $input['star']->id)
                ->where('status', '=', 'ACTIVE')
                ->first();
            if (!$gift) {
                return false;
            }
        } else {
            return false;
        }
        $star_chat_show = new model_chat_show;
        $star_chat_show->star_id = $input['star']->id;
        $star_chat_show->show_type = $input['type'];
        $star_chat_show->credits_price = $credits_price;
        $star_chat_show->started_at = date('Y-m-d H:i:s');
        if (!empty($input['title']) && is_string($input['title'])) {
            $star_chat_show->title = substr($input['title'], 0, 120);
        }
        if (!empty($input['description']) && is_string($input['description'])) {
            $star_chat_show->description = substr($input['description'], 0, 120);
        }
        if (!empty($input['hashtags']) && is_string($input['hashtags'])) {
            $tmp = explode(',', preg_replace('/[^,a-zA-Z0-9]/', '', $input['hashtags']));
            $hashtags = [];
            foreach ($tmp as $tag) {
                if (!empty($tag) && 2 <= strlen($tag)) {
                    $hashtags[] = $tag;
                }
                if (120 <= strlen(implode(',', $hashtags))) {
                    array_pop($hashtags);
                    break;
                }
            }
            $star_chat_show->hashtags = implode(',', $hashtags);
        }
        $star_chat_show->save();

        $input['star']->last_on = date('Y-m-d H:i:s');
        if ($input['star']->status != 'OFFLINE') {
            $input['star']->status = $input['type'];
        }
        $input['star']->broadcast_cnt++;
        $input['star']->save();

        if (stripos($input['star']->services, 'VIDEO_CHAT') === false) {
            $services = explode(',', $input['star']->services);
            $services[] = 'VIDEO_CHAT';
            if (false !== ($pos = array_search('NONE', $services))) {
                array_splice($services, $pos, 1);
            }
            $input['star']->services = implode(',', $services);
            $input['star']->save();
        }
        return $star_chat_show;
    }

    public static function end_show($star) {
        //END ALL OPEN SHOWS
        $shows = model_chat_show::where('star_id', '=', $star->id)
            ->where('ended_at', '=', '0000-00-00 00:00:00')
            ->useWritePdo()
            ->get();
        foreach ($shows as $show) {
            $show->update(['ended_at' => date('Y-m-d H:i:s')]);
        }
        $star->update([
            'status' => 'OFFLINE',
            'last_on' => date('Y-m-d H:i:s'),
        ]);
        $redis = Redis::connection('chat');
        $redis->publish('v1.show.end', json_encode([
            'broadcaster' => $star->profile_name
        ]));
        /*
        //stream delay causes abrupt end to show, delay 30 seconds
        Log::notice('setup terminate');
        \WebUtils::terminate_run(function() use ($star) {
            sleep(30);
            $redis = Redis::connection('node1');
            $redis->publish('v1.show.end', json_encode([
                'broadcaster' => $star->profile_name
            ]));
            Log::notice('terminate ran');
        });
        */
    }

    public function cdn_url($token){
        $baseUrl = $this->base_url();
        $streamName = $this->stream_name('all');
        
        // Wowza Experiments:  Make the following edits for all streams 
		$streamName = str_replace('ngrp:', '', $streamName);
		$streamName = str_replace('_all', '', $streamName);



		if ($this->show_type == 'PAY_PER_VIEW') {
		
//			Commented out for Wowza experiments
// 				$streamName = str_replace('ngrp:', '', $streamName);
// 				$streamName = str_replace('_all', '', $streamName);
	//             Log::notice("In cdn_url returning = ".print_r('https://'.\WhiteLabel::chat('video_edge').'/live/amlst:'.$streamName.'/playlist.m3u8?token='.$token,true));
		return 'https://'.\WhiteLabel::chat('video_edge').'/live/amlst:'.$streamName.'/playlist.m3u8?token='.$token;
	//            return 'https://edge1-dev.collide.com/live/amlst:'.$streamName.'/playlist.m3u8?token='.$token;
			//return 'https://edge1-dev.collide.com/live/'.$streamName.'_288p/playlist.m3u8?token='.$token;
		} else {
					return 'https://'.$baseUrl.'/amlst:'.$streamName.'/playlist.m3u8?token='.$token;
//				return 'http://'.$baseUrl.'/almst:'.$streamName.'/playlist.m3u8?token='.$token;
//				return 'http://'.$baseUrl.'/live/_definst_/almst:'.$streamName.'/playlist.m3u8?token='.$token;
		}
		}

    public function lambda_url($token){
        $baseUrl = $this->base_url();
        $streamName = $this->stream_name('all');
        //$streamName = str_replace('ngrp:', '', $streamName);
        //$streamName = str_replace('_all', '', $streamName);
        return 'https://'.$baseUrl.'/prod/'.$streamName.'/playlist.m3u8?token='.$token;
    }

    public function hls_url($token = 'freeStream', $quality = 'full'){
        $baseUrl = $this->base_url();
        $streamName = $this->stream_name($quality);

        return 'http://'.$baseUrl.'/'.$streamName.'/playlist.m3u8?token='.$token;
    }

    public function rtmp_url($token = 'freeStream', $quality = 'full'){
        $baseUrl = $this->base_url();
        $streamName = $this->stream_name($quality);

        return 'rtmp://'.$baseUrl.'?token='.$token.'&'.$streamName;
    }

    public function dash_url($token = 'freeStream', $quality = 'full'){
        $baseUrl = $this->base_url();
        $streamName = $this->stream_name($quality);

        return 'http://'.$baseUrl.'/'.$streamName.'/manifest.mpd?token='.$token;
    }

    public function base_url(){
        $videoApp = \WhiteLabel::chat('video_cdn_app');
        $videoHost = \WhiteLabel::chat('video_cdn');

        if($videoApp){
            return $videoHost.':1935/'.$videoApp;
        } else {
            return $videoHost;
        }
    }

    public function stream_name($quality){

        // If we don't know the quality we go full
        if (!in_array($quality, ['270p', '360p', '480p', 'all'])) {
            $quality = '480p';
        }

        $channel = 'show_'.$this->id.'.stream_'.$quality;

        if($quality == 'all'){
            return 'ngrp:'.$channel;
        } else {
            return 'mp4:'.$channel;
        }

    }

    public function broadcast_data($token){

        $videoHost = \WhiteLabel::chat('video_host');
        $videoHost .= ':1935';

        $videoApp = \WhiteLabel::chat('video_app');

        $channel = 'show_'.$this->id.'.stream';

        return [
            'url' => 'rtmp://'.$videoHost.'/'.$videoApp.'/?token='.$token,
            'full' => 'rtmp://'.$videoHost.'/'.$videoApp.'/'.$channel.'?token='.$token,
            'channel' => $channel,
        ];
    }

    public function chat_room(){
        return $this->model->userProfile()->first()->display_name;
    }

    public static function lookup($input = []){
        $join = $left_join = [];
        $single_result = false;
        $count = '*';
        
        $input['group'] = !empty($input['group'])?$input['group']:null;
        $group = [];
        switch ($input['group']) {
        case 'star_id':
            $group[] = 'star_chat_show.star_id';
            break;
        }        
        
        $query = model_chat_show::selectRaw('star_chat_show.*');
        // Get the duration in seconds for sorting.
        $query->
        	selectRaw("IF(star_chat_show.ended_at<>'0000-00-00 00:00:00'"
        		.",TO_SECONDS(star_chat_show.ended_at)-TO_SECONDS(star_chat_show.started_at)"
        		.",NOW()-TO_SECONDS(star_chat_show.started_at)) as show_seconds");
        
        if (!empty($input['with']['star'])) {
            $query->with('star');
        }
        if (!empty($input['with']['media_profile'])) {
            if (!is_string($input['with']['media_profile'])) {
                $input['with']['media_profile'] = 'PROFILE';
            }
            $query->with(['star.media' => function($query) use ($input) {
                $query->where('type', '=', $input['with']['media_profile']);
            }]);
        }
        if (!empty($input['with']['star.user'])) {
            $query->with('star.user');
        }
        if (!empty($input['q'])) {
            $left_join['star'] = true;
            $query->where(function($q) use ($input) {
                $q->orWhere('star.profile_name', 'LIKE', $input['q'].'%');
            });
        }
        if (!empty($input['star_id'])) {
            $query->where('star_chat_show.star_id', '=', $input['star_id']);
        }
        if (!empty($input['user_id'])) {
            $join['user_chat_show'] = true;
            $query->selectRaw('user_chat_show.created_at as purchased_at');
            $query->where('user_chat_show.user_id', '=', $input['user_id']);
        }
        if (!empty($input['get_viewers'])) {
            $left_join['user_chat_show'] = true;
            $query->selectRaw('SUM(IF(user_chat_show.user_id IS NULL, 0, 1)) as viewers');
            $group[]="star_chat_show.id";
         }
        if (!empty($input['show_type'])) {
            if (!is_array($input['show_type'])) {
                $input['show_type'] = [$input['show_type']];
            }
            $query->whereIn('star_chat_show.show_type', $input['show_type']);
        }
        if (isset($input['ended'])) {
            if ($input['ended']) {
                $query->where('star_chat_show.ended_at', '!=', '0000-00-00 00:00:00');
            } else {
                $query->where('star_chat_show.ended_at', '=', '0000-00-00 00:00:00');
            }
        }
        if (!empty($input['created_at_greater_equal'])) {
            $query->where('star_chat_show.created_at', '>=', $input['created_at_greater_equal']);
        }
        if (!empty($input['created_at_less_equal'])) {
            $query->where('star_chat_show.created_at', '<=', $input['created_at_less_equal']);
        }

        $input['order'] = !empty($input['order'])?$input['order']:null;
        $input['order_dir'] = !empty($input['order_dir'])?$input['order_dir']:'DESC';
        $order = '';
        switch ($input['order']) {
        case 'star_profile_name':
            $order = 'star.profile_name';
            $left_join['star'] = true;
            break;
        case 'created_at':
            $order = 'star_chat_show.created_at';
            break;
        case 'credits':
            $order = 'star_chat_show.credits_price';
            break;
        case 'show_seconds':
            $order = 'show_seconds';
            break;
        case 'show_start':
            $order = 'star_chat_show.started_at';
            break;
        case 'show_end':
            $order = 'star_chat_show.ended_at';
            break;
        case 'show_type':
            $order = 'star_chat_show.show_type';
            break;
        case 'viewers':
            $order = 'viewers';
            break;
        default:
            $order = 'star_chat_show.id';
            break;
        }
        if (!empty($join['star'])) {
            $query->join('star', 'star.id', '=', 'star_chat_show.star_id');
        }
        if (!empty($join['user_chat_show'])) {
            $query->join('user_chat_show', 'user_chat_show.star_chat_show_id', '=', 'star_chat_show.id');
        }
        if (!empty($left_join['user_chat_show'])) {
            $query->leftJoin('user_chat_show', 'user_chat_show.star_chat_show_id', '=', 'star_chat_show.id');
        }
        if (!empty($left_join['star'])) {
            $query->leftJoin('star', 'star.id', '=', 'star_chat_show.star_id');
        }
        $found = 0;
        if (!empty($input['return_found'])) {
            $found = $query->count($count);
        } else if (!empty($input['return_count'])) {
            return $query->count($count);
        }
        if (!empty($group)) {
            $query->groupBy($group);
        }
        if (!empty($order)) {
            $query->orderBy($order, $input['order_dir']);
        }
        if (!empty($input['offset'])) {
            $query->offset($input['offset']);
        }
        if (!empty($input['limit'])) {
            $query->limit($input['limit']);
        }
        if ($single_result) {
            $rows = $query->first();
        } else {
            $rows = $query->get();
        }
        if (!empty($input['return_found'])) {
            return [$rows, $found];
        }
        return $rows;
    }

    public function getDurationStringAttribute() {
        $ended = $this->ended_at == '0000-00-00 00:00:00' ? time() : strtotime($this->ended_at);
        return \WebUtils::seconds_to_string($ended - strtotime($this->started_at));
    }

    public function getIsOpenAccessAttribute() {
        return in_array($this->show_type, ['FREE', 'GIFT']);
    }

    public function show_joined($user, $user_subscription='', $user_chat_show='') {
        if (!$user) {
            return false;
        }

        if ($this->is_open_access) {
            return true;
        }

        if (is_string($user_subscription)) {
            $user_subscription = user_subscribe::is_user_subscription($this->star_id, $user->id, 'MEDIA');
        }

        if ($user_subscription) {
            return true;
        }

        if ($this->show_type == 'PAY_PER_MINUTE') {
            if ($user->credits < $this->credits_price) {
                return false;
            }
        }

        if (is_string($user_chat_show)) {
            $user_chat_show = user_chat_show::get_user_show($this->id, $user->id);
        }

        if ($user_chat_show) {
            return true;
        }

        return false;
    }

    public function getShowTypeCleanAttribute() {
        return model_chat_show::clean_attribute_from_show_type($this->show_type);
    }

    public function getStateAttribute() {
        if ($this->ended_at != '0000-00-00 00:00:00') {
            //broadcast ended within TIME_TIL_ABORT seconds of show ending?
            $log_finished_success = star_chat_log::where('star_id', '=', $this->star_id)
                ->where('created_at', '<', ''.$this->ended_at)
                ->where('ended_at', '>=', date('Y-m-d H:i:s', strtotime(''.$this->ended_at) - model_chat_show::TIME_TIL_ABORT))
                ->orderBy('id', 'DESC')
                ->first();
            if ($log_finished_success) {
                //give 10 seconds to wrap up HLS playlist on client
                if (time() < strtotime(''.$log_finished_success->ended_at)) {
                    //this should return either STARTED or RESUMED, but extra query inefficiency probably not worth the effort
                    return 'RESUMED';
                }
                return 'FINISHED_SUCCESS';
            }
            return 'FINISHED_ABORT';
        }
        $log_broadcasting = star_chat_log::where('star_id', '=', $this->star_id)
            ->where('created_at', '>=', ''.$this->started_at)
            ->orderBy('started_at', 'DESC')
            ->limit(2)
            ->get();
        if (!$log_broadcasting->count()) {
            return 'PENDING';
        }
        if ($log_broadcasting->count() == 1) {
            if ($log_broadcasting->first()->ended_at == '0000-00-00 00:00:00') {
                return 'STARTED';
            }
            return 'DISCONNECTED';
        }
        if ($log_broadcasting->first()->ended_at == '0000-00-00 00:00:00') {
            return 'RESUMED';
        }
        return 'DISCONNECTED';
    }

    public function associate_media_item($media_purchase_item) {
        star_chat_show_media::where('media_purchase_item_id', '=', $media_purchase_item->id)->delete();

        $sql = 'INSERT IGNORE INTO star_chat_show_media (star_chat_show_id, media_purchase_item_id)
                                      VALUES (:star_chat_show_id, :media_purchase_item_id)';
        DB::statement($sql, [
            'star_chat_show_id' => $this->id,
            'media_purchase_item_id' => $media_purchase_item->id,
        ]);
    }

    public static function shows_allowed($star) {
        $allowed = [];
    	/*$streams_array = explode(',',$star->stream_types);
    	if (in_array('PAY_PER_VIEW',$streams_array)) $allowed[]='PPV';
    	if (in_array('PAY_PER_MINUTE',$streams_array)) $allowed[]='PPM';
        $sponsor = star_sponsor::where('star_id', '=', $star->id)
            ->where('status', '=', 'ACTIVE')
            ->first();
        if ($sponsor) {
            $allowed[] = 'FREE';
        }
        $gift = star_gift::where('star_id', '=', $star->id)
            ->where('status', '=', 'ACTIVE')
            ->first();
        if ($gift) {
            $allowed[] = 'GIFT';
        }*/
        // Always allow to Pay Per View if nothing else set.
        if (count($allowed) == 0){
        	$allowed[] = 'PPV';
        }
        return $allowed;
    }

    public function get_gift(){
        return star_gift::get_current_gift($this->star_id);
    }

    public function notified_all() {
        return ($this->notify_email_at != '0000-00-00 00:00:00'
                && $this->notify_sms_at != '0000-00-00 00:00:00'
                && $this->notify_sns_at != '0000-00-00 00:00:00');
    }
    
    public static function get_star_dashboard_streams( $star_id, $offset=0, $count=20, $column = 'started_at',$direction = 'desc'){
    	$q=model_chat_show::selectRaw( "star_chat_show.started_at as 'Show Date'")
    		->selectRaw("((star_chat_show.ended_at-star_chat_show.started_at)) as seconds")
    		->selectRaw("star_chat_show.show_type as 'Show Type',count(*) as viewers")
    		->selectRaw("(SELECT "
    			."if(star_chat_show.show_type IN ('PAY_PER_VIEW','PAY_PER_MINUTE')"
    			.",sum(user_credit_log.credits),0) from user_credit_log "
				."left join user on user_credit_log.user_id = user.id "
				."where user_credit_log.created_at between star_chat_show.started_at "
				."and star_chat_show.ended_at  and user_credit_log.action "
				."in ('VIDEO_CHAT_MINUTE', 'VIDEO_CHAT_SESSION') "
				."and user_credit_log.star_id = star_chat_show.star_id) as credits"
				)
			->where('star_chat_show.star_id','=',$star_id)
			->groupBy('star_chat_show.id')
			->orderBy ($column, $direction)
			->offset($offset)
			->limit($count)
			;
		$data = $q->get()->toArray();
		
		$found = model_chat_show::where('star_chat_show.star_id','=',$star_id)
			->groupBy('star_chat_show.id')->get()->count();
		
		foreach( $data as $index => $entry ){
			$data[$index]['dollars'] = user_credit_log::credits_to_dollars($entry['credits']);
			if ($entry['seconds']<60) {
				$duration = $entry['seconds']."s";
				}
			else {
				$duration = ( round($entry['seconds']/60)%60 ).'m';
				if ($entry['seconds']>3600){
					$duration = ( floor($entry['seconds']/3600 )).'h'.$duration ;
				}
			}
			$data[$index]['duration'] = $duration;
			$data[$index]['clean_attribute'] = model_chat_show::clean_attribute_from_show_type($entry['Show Type'],'short');
		
		
    }
    
		$output = [
                   'recordsTotal' => $found,
                   'recordsFiltered' => $found,
                   'data' => $data
                   ];
    	
        	return $output ;
}

    public static function clean_attribute_from_show_type($show_type,$length = 'long') {
        if ($show_type == 'PAY_PER_VIEW') {
            return ($length == 'long')?'Flat Rate':'PPV';
        }
        if ($show_type == 'PAY_PER_MINUTE') {
            return ($length == 'long')?'Pay Per Minute':'PPM';
        }
        if ($show_type == 'GIFT') {
            return 'Gift';
        }
        return 'Sponsored';
    }
    


}
