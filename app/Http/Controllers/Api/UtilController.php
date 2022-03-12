<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogEtcPosts;
use Illuminate\Http\Request;
use App\Models\user_post_likes;
use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class UtilController extends Controller
{


    public $codeDeleteSuccess = 202;
    public $codeNoAuthorized =401;
    public $codeCretedSuccess = 201;
    public $codeNotFaund = 404;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
  /*  public function sexyFile(){

        return response()->json(['success'=>['account' => "no"]]);
    }*/


    protected function _post_json($star_post, $input=[]){
        // Log::debug("In _star_post_json with \$star_post = ".print_r($star_post,true));

        $post = $star_post;
       /* $version_record = $star_post->version_record;
        $medium = isset($input['medium'])?$input['medium']:$star_post->medium;
        $star = $star_post->star;*/

        $user = Auth::user();
        if($user) {
            $likes_this = user_post_likes::is_liked([
                'user_id'=> $user->id
              /*  ,'star_id'=> $star->id*/
                ,'post_id'=>$post->id
            ]);
        }

        /*$summary = star_post_version::where('id',$star_post->star_post_version_id)->first();*/

        $res =[
            'post_id'=>$post->id
            , 'post_views'=>$post->views
           /* , 'is_liked'=>$likes_this*/
            , 'post_is_liked'=>$likes_this
           /* , 'post_text_content'=> $version_record->text*/
           /* , 'post_date'=> date("F d, Y", strtotime($version_record->created_at))*/
            /*, 'post_raw_date'=> strtotime($version_record->created_at)*/
           /* , 'creator_thumb'=> $star->profile_v1_image()*/
           /* , 'creator_profile_name'=>$star->profile_name*/
           /* , 'post_headline'=> $version_record->title*/
            , 'post_access'=> $post->access_type
            , 'post_media_content'=>''
            , 'post_media_thumb'=>''
            , 'post_status'=>$post->status
           /* , 'post_summary'=>$summary->summary*/
            , 'post_comments_permission'=>$post->comments
            , 'post_comments_level'=>$post->comments_level
            , 'post_weight'=>$post->weight
            , 'post_type'=>$post->type
            , 'post_likes'=>$post->likes
        ];
        

        if (isset($input['access_types'])){
            $res['post_this_user_access']= implode(',',$input['access_types']);
        }

        return $res;
    }

    public function getPostNextAndPrev(Request $request)
    {

        $post = BlogEtcPosts::where('id', '=', $request->post_id)->first();
        if ($post) {
            $results = ['prev' => $post->prev(), 'next' => $post->next(), 'success' => true];
            return \json_encode($results);
        } else
            return false;
    }

    public function getModelSchedule(Request $request)
    {


      
       

        $model_id = $request->model_id;
        
        $schedules_new = array();
        $schedules = array('Sunday','Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday');


        foreach($schedules as $day ){

                $f = strtotime('last '.$day.' 00:00:00');
                $dateString = new DateTime(date('l F j Y g:i:s A',$f));      
                
                
                $f = strtotime('last '.$day.' 24:00:00');
                $dateStringt = new DateTime(date('l F j Y g:i:s A',$f));      
                



                $schedules_new[] = [
                    'n' => $dateString->format('w'),
                    'day' => $dateString->format('l'),
                    'from' => $dateString->format('H:i:s'),
                    'till'=> '24:00:00',
                    ];

            


        }


        if (($schedules_new)&&(auth('api')->user()->userProfile->timezone))
            return \json_encode($schedules_new);
        else
            return false;
    }
}
