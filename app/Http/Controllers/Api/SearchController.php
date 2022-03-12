<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 8/23/2019
 * Time: 11:27 AM
 */

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\Specialties;
use App\Models\UserProfile;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use App\Models\HoroscopeInfo;

use App\Models\UserHoroscope;
use Spatie\Searchable\Search;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\HoroscopeZodiacSigns;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\v1\PsychicResource;
use App\Http\Resources\v1\SpecialResource;
use App\Http\Resources\v1\CategoryResource;
use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\v1\HoroscopeInfoResource;
use App\Http\Resources\v1\UserHoroscopeResource;
use App\Http\Resources\v1\PsychicProfileResource;
use App\Http\Resources\v1\UserFrontBasicResource;
use App\Http\Resources\v1\SpecialResourceCollection;
use App\Http\Resources\v1\CategoryResourceCollection;
use App\Http\Resources\v1\UserBasicResourceCollection;
use App\Http\Resources\v1\HoroscopeZodiacSignsResource;
use App\Http\Resources\v1\HoroscopeInfoResourceCollection;
use App\Http\Resources\v1\UserHoroscopeResourceCollection;
use App\Http\Resources\v1\HoroscopeZodiacSignsResourceCollection;

class SearchController extends Controller
{

    public function __construct()
    {

    }

    protected function filterPsychics(Request $request)
    {

/*
        $data = DB::table('user_category')->select(DB::Raw("user_category.user_id"))
		->leftJoin("user","user_category.user_id","user.id")
//		->leftJoin("user_profile","user_category.user_id","user_profile.user_id")
			->leftJoin("user_service","user_category.user_id","user_service.user_id")
			->where("user_category.category_id", "=", 7)
			->where("user_service.active", "=", TRUE)
			->where("user.email_validated", "=", 1)
			->where("user.fraud", "=", 0)
			->where("user.account_status", "=", "ACTIVE")
			->where("user.test_user", "=", 0)
			->where("user.profile_percent", "!=", 0)
            ->distinct("user_category.user_id")->get();
			

         echo json_encode(array("data"=>count($data)));

        return;
*/
        $services = DB::table('user_service')
            ->select('user_id')
            ->where('active', true)
            ->distinct();
        // ->groupBy('user_id');

        $q = User::select('user.*');
        $q->join('user_profile', 'user_profile.user_id', '=', 'user.id')
            ->joinSub($services, 'services', function ($join) {
                $join->on('user.id', '=', 'services.user_id');
            });

        $q->where('user.email_validated', 1);
        $q->where('user.fraud', 0);
        $q->where('user.account_status', 'ACTIVE');
        $q->where('user.test_user', 0);
        //$q->where('role_id', '=', WhiteLabel::roleId('Model'));
        // $q->where('user_profile.haedshot_path', '!=', '');
        $q->where('user.profile_percent', '!=', 0);
        $q->distinct();
        if ($cat = $request->get('cat')) {
            $q->whereHas('categories', function ($query) use ($cat) {
                return $query->where('slug', $cat);
            });
        }


        if ($filters = json_decode($request->get('filters'), true)) {
            foreach ($filters as $field => $value) {
                if ($field == 'online') {
                    $q->where('online', 1)->whereNotNull('description');
                    //$q->whereNotNull('user_profile.cover_path');
                    //$q->whereNotNull('user_profile.haedshot_path');
                    //$q->whereRaw('(user_profile.intro_video_path IS NOT NULL OR user_profile.intro_audio_path IS NOT NULL)');
                    $q->inRandomOrder();

                } else {

                    if ($field == 'rating') {
                        $q->where('user.top_rating', '!=', 0);
                        // $q->where('online', 1);
                        $q->join('user_schedule', 'user.id', '=', 'user_schedule.user_id');
                        $q->where(function ($query) {
                            $query->orWhere('online', 1);
                            $query->orWhere(function ($query) {
                                $now = now();
                                $day = \strtolower($now->format('D'));
                                $time = $now->format('H:i:s');
                                $query->where('user_schedule.active', 1)->where('user_schedule.day', $day)->whereRaw("TIME(user_schedule.from) < TIME('$time') AND TIME(user_schedule.till) > TIME('$time')");
                            });
                        });
                        $q->orderBy('user.top_rating', 'DESC');

                    } else if ($field == 'popular') {
                        $q->whereNotNull('user_profile.t_clients');
                        $q->where('user_profile.t_clients', '!=', 0);
                        $q->orderBy('user_profile.t_clients', 'DESC');
                        $q->orderBy('priority', 'DESC');
                    } else if ($field == 'is_streaming_live') {                       
                        $q->where('user.is_streaming_live', '=', $value);
                      }
                    else {
                        if ($field == 'featured') {
                            $orderByPriority = true;
                        }

                        $q->where($field, $value);
                    } 
                }

            }
        }
        if ($request->page && $request->page == 1) {
            $q->where('lost_requests', '<', 10);
        }
        
        
       

        if (isset($orderByPriority)) {
            $q->orderBy('user.profile_percent', 'DESC');
            $q->orderBy('priority', 'DESC');
        } else {
            $q->orderBy('priority', 'DESC');
            $q->orderBy('user.profile_percent', 'DESC');
        }

        $q->orderBy('online', 'DESC');
        $q->orderBy('lost_requests', 'ASC');

        return ($perPage = $request->get('per_page')) ? $q->paginate($perPage) : $q->get();

    }

    /**
     * The original method is commented below.
     * @author alcidesrh@gmail.com
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPsychics(Request $request)
    {
       return PsychicResource::collection($this->filterPsychics($request));
    }

    public function getFavorites(Request $request)
    {

        $user = Auth::guard('api')->user();
        $models = null;

        if (!is_null($user)) {
  
            $models = $user->favorites()->get();
        }

        return PsychicResource::collection($models);
    }

    public function getPsychicsSearch(Request $request)
    {
        $query = $request->input('query');
        $models = new UserBasicResourceCollection(User::getModelsByDisplayName($query));

        return $models;
    }

    // /**
    //  * The original method is commented below.
    //  * @autor alcidesrh@gmail.com
    //  * @param $id
    //  * @return PsychicProfileResource
    //  */
    // public function getPsychic($id, Request $request)
    // {

    //     if ($request->offset) { //Request from psychic profile

    //         list($hours, $minutes) = explode(':', $request->offset);
    //         $seconds = $hours * 60 * 60 + $minutes * 60;

    //         // Get timezone name from seconds
    //         $timezone = timezone_name_from_abbr('', $seconds, 1);

    //         if ($timezone === false) {
    //             $timezone = timezone_name_from_abbr('', $seconds, 0);
    //         }
    //     }

    //     if ($request->client) {
    //         $user = User::find($request->client);
    //         if ($user->userProfile->timezone) {
    //             $timezone = $user->userProfile->timezone;
    //         }
    //     }

    //     return new PsychicProfileResource(User::find($id), $timezone ?? null);
    // }

    /**
     * The original method is commented below.
     * @autor alcidesrh@gmail.com
     * @param $slug
     * @return UserFrontBasicResource
     */

    public function getModel($id, Request $request)
    {
        $model = new UserFrontBasicResource(User::getModelByIdOrDisplayName($id));

        return $model;
    }


    /**
     * @author alcidesrh@gmail.com
     * @param Request $request
     * @return mixed
     */
    public function getCategories($slug = null, Request $request)
    {
        return $slug ? new CategoryResource(Category::where('slug', $slug)->first()) : new CategoryResourceCollection(Category::withCount('users')->get());
    }

    public function getHoroscopesign($slug = null, Request $request)
    {

        return $slug ? new HoroscopeZodiacSignsResource(HoroscopeZodiacSigns::where('slug', $slug)->first()) : new HoroscopeZodiacSignsResourceCollection(HoroscopeZodiacSigns::all());
    }

  
    public function getWeeks(Request $request)
    {

        $query = HoroscopeInfo::select(DB::raw("CONCAT(DATE_FORMAT(start_week, '%m/%d/%Y'),' - ',DATE_FORMAT(end_week, '%m/%d/%Y')) as name"),DB::raw("CONCAT(start_week,'_',end_week) as idweek"))
                ->groupBy('start_week','end_week');
        return response()->json(['data' => $query->get()],200);
        

    }

  
    public function getHoroscopeInfo(Request $request)
    {

        
        $signs = $request->sign;
        $weeks = $request->week;
        $query = HoroscopeInfo::select('horoscope_info.*');


        if(!$request->archived)
        $query->where('archived','=',0);

        if($weeks)
        $query->where(function ($query) use ($weeks) {
            foreach ($weeks as $week) {
                $week_s = explode('_',$week);
                $query->where('start_week', '=', ["{$week_s[0]}"]);
                $query->where('end_week', '=', ["{$week_s[1]}"]);
            }
        });


        if($signs)
        $query->where(function ($query) use ($signs) {
            foreach ($signs as $sign) {
                $query->orWhere('horoscope_zodiac_signs_id', '=', ["{$sign}"]);
            }
        });


        $query->orderBy('start_week', 'desc');

        $result = new HoroscopeInfoResourceCollection($query->get());

        return $result;
    }

    public function getUserHoroscope($slug = null, Request $request)
    {

        $query = UserHoroscope::select('user_horoscope.*','horoscope_zodiac_signs.name as sign');
        $query->join('horoscope_zodiac_signs', function ($query) {
            $query->whereRaw('DATE_FORMAT(user_horoscope.birth_date,"%m/%d") BETWEEN horoscope_zodiac_signs.start_period and horoscope_zodiac_signs.end_period');
        });
        return new UserHoroscopeResourceCollection($query->get());


    }




    public function getSpecialties($slug = null, Request $request)
    {
        return $slug ? new SpecialResource(Specialties::where('slug', $slug)->first()) : new SpecialResourceCollection(Specialties::withCount('users')->paginate($request->get('per_page')));
    }

    /**
     * Search is performed case insensitive in name, last_name, display_name attributes of UserProfile and name's attribute of Category.;
     * @author alcidesrh@gmail.com
     *
     */

    public function search(Request $request)
    {

        $input = $request->all();
        $searchTerms = [];
        if (isset($input['search'])) {
            $searchTerms = array_filter(explode(" ", $input['search']), function ($value) {
                return !empty($value);
            });
        }

        $services = DB::table('user_service')
            ->select('user_id')
            ->where('active', true);

        if (isset($input['call']) || isset($input['video']) || isset($input['chat'])) {
            $where = "";
            if (isset($input['call'])) {
                $where = "service_id = 1";
            }

            if (isset($input['video'])) {
                $where .= $where ? " OR service_id = 3" : "service_id = 3";
            }

            if (isset($input['chat'])) {
                $where .= $where ? " OR service_id = 2" : "service_id = 2";
            }

            $where = "($where)";
            $services->whereRaw($where);

            if (isset($input['min']) || isset($input['max'])) {
                if ($input['min'] == -1) {
                    $services->where('rate', '<=', $input['max']);
                } else if ($input['max'] == -1) {
                    $services->where('rate', '>=', $input['min']);
                } else {
                    $services->where('rate', '<=', $input['max'])->where('rate', '>=', $input['min']);
                }

            }
        } else if (isset($input['min']) || isset($input['max'])) {

            if ($input['min'] == -1) {
                $services->where('rate', '<=', $input['max']);
            } else if ($input['max'] == -1) {
                $services->where('rate', '>=', $input['min']);
            } else {
                $services->where('rate', '<=', $input['max'])->where('rate', '>=', $input['min']);
            }

        }
        $services->whereNotNull('rate');
        $services->distinct();

        $query = User::select('user.*')
            ->join('user_profile', 'user.id', '=', 'user_profile.user_id')
            ->joinSub($services, 'services', function ($join) {
                $join->on('user.id', '=', 'services.user_id');
            })
            ->where('user.email_validated', 1)
            ->where('user.fraud', 0)
            ->where('user.account_status', 'ACTIVE')
            ->where('user.test_user', 0)
            ->where('user.role_id', '=', WhiteLabel::roleId('Model'))
            ->where('user_profile.haedshot_path', '!=', '')
            ->where('user.profile_percent', '!=', 0)
            ->where(function ($query) use ($searchTerms) {
                foreach (['name', 'last_name', 'display_name'] as $attribute) {
                    foreach ($searchTerms as $searchTerm) {
                        $sql = "LOWER(user_profile.{$attribute}) LIKE ?";
                        $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                        $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                    }
                }
                foreach (['email'] as $attribute) {
                    foreach ($searchTerms as $searchTerm) {
                        $sql = "LOWER({$attribute}) LIKE ?";
                        $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                        $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                    }
                }
            });

        if (isset($input['ability']) && !empty($input['ability'])) {
            $query->join('user_category', 'user.id', '=', 'user_category.user_id')->join('category', 'category.id', '=', 'user_category.category_id')
                ->whereIn('category.slug', \is_array($input['ability']) ? $input['ability'] : explode(',', $input['ability']));
        }
        if (isset($input['category']) && !empty($input['category'])) {
            $query->join('user_specialties', 'user.id', '=', 'user_specialties.user_id')->join('specialties', 'specialties.id', '=', 'user_specialties.specialties_id')
                ->whereIn('specialties.slug', \is_array($input['category']) ? $input['category'] : explode(',', $input['category']));
        }
        if (isset($input['tool']) && !empty($input['tool'])) {
            $query->join('user_tools', 'user.id', '=', 'user_tools.user_id')->join('tools', 'tools.id', '=', 'user_tools.tools_id')
                ->whereIn('tools.slug', \is_array($input['tool']) ? $input['tool'] : explode(',', $input['tool']));
        }
        if (isset($input['style']) && !empty($input['style'])) {
            $query->join('user_styles', 'user.id', '=', 'user_styles.user_id')->join('styles', 'styles.id', '=', 'user_styles.styles_id')
                ->whereIn('styles.slug', \is_array($input['style']) ? $input['style'] : explode(',', $input['style']));
        }
        if (isset($input['language']) && !empty($input['language'])) {
            $query->join('user_languages', 'user.id', '=', 'user_languages.user_id')->join('languages', 'languages.id', '=', 'user_languages.languages_id')
                ->whereIn('languages.slug', \is_array($input['language']) ? $input['language'] : explode(',', $input['language']));
        }
        if (isset($input['online']) || (isset($input['sort']) && $input['sort'] == 2)) {
            $query->join('user_schedule', 'user.id', '=', 'user_schedule.user_id');
            $query->where(function ($query) {
                $query->orWhere('online', 1);
                $query->orWhere(function ($query) {
                    $now = now();
                    $day = \strtolower($now->format('D'));
                    $time = $now->format('H:i:s');
                    $query->where('user_schedule.active', 1)->where('user_schedule.day', $day)->whereRaw("TIME(user_schedule.from) < TIME('$time') AND TIME(user_schedule.till) > TIME('$time')");
                });
            });
        }

        if (isset($input['sort'])) {
            // if ($input['sort'] == 2) {
            // $query->where('online', 1);

            // $query->orderBy('user_profile.intro_video_path', 'DESC');
            // $query->orderBy('user_profile.intro_audio_path', 'DESC');
            // $query->orderBy('user_profile.cover_path', 'DESC');
            // } else {

            if ($input['sort'] == 3) {

                // $query->where('user.top_rating', '!=', 0);

                $query->orderBy('user.top_rating', 'DESC');
            } else if ($input['sort'] == 4) {
                $query->orderBy("user.featured", 'desc');
                $query->orderBy('priority', 'DESC');
            } else if ($input['sort'] == 5) {
                $query->orderBy("user_profile.t_clients", 'desc');
                $query->orderBy('priority', 'DESC');
            }
            // }
        }
        if ($request->page && $request->page == 1) {
            $query->where('lost_requests', '<', 10);
        }

        $query->orderBy('user.profile_percent', 'DESC');
        $query->orderBy('online', 'DESC');
        $query->orderBy('lost_requests', 'ASC');
        $query->orderBy('priority', 'DESC');
        

        $query->distinct();
        $query->groupBy('user.id');

        return PsychicResource::collection(($perPage = $request->get('per_page')) ? $query->paginate($perPage) : $query->get());
    }

}
