<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Review;
use App\Models\UserSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class PsychicProfileResource extends JsonResource
{
    private $timezone;

    public function __construct($query, $timezone = null){
        $this->timezone = $timezone;
        parent::__construct($query);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $profile = new UserProfileBasicResource($this->userProfile()->first());
        $schedules = UserSchedule::where('user_id', $this->id)->where('active', 1)->get();

        $timezone = $this->timezone ?? $profile->timezone;
        
            if($timezone)
             foreach ($schedules as $value) {
                $date = Carbon::createFromFormat('H:i:s', $value->from, $timezone);
                $value->from = $date->format('H:i:s');
                $date = Carbon::createFromFormat('H:i:s', $value->till, $timezone);
                $value->till = $date->format('H:i:s');
             }

             if($this->online && $this->last_log_in < now()->subHours(30)){
                $user = User::find($this->id);
                $user->online = 0;
                $user->save();
            }
  
             
        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
            'profile' => $profile,
            'services'=> new UserServiceResourceCollection($this->userService()->where('active', "=", 1)->get()),
            'categories'=> new CategoryResourceCollection($this->categories()->get()),
            'specialties'=> new SpecialResourceCollection($this->specialties()->get()),
            'tools'=> new ToolsResourceCollection($this->tools()->get()),
            'styles'=> new StylesResourceCollection($this->styles()->get()),
            'reviews' => new ReviewBasicResourceCollection(Review::where('psychic_id', $this->id)->where('status', 'Posted')->orderBy('created_at','DESC')->limit(5)->get()),
            'reviews_count' => $this->reviews()->where('status', 'Posted')->count(),
            'reviews_rating' => Review::where('psychic_id', '=', $this->id)->where('status', 'Posted')->avg('rating'),
            'reviews_count_start' => Review::where('psychic_id', '=', $this->id)->where('status', 'Posted')->select('rating', DB::raw('count(*) as total'))->groupBy('rating')->get(),
            'credentials'=> new CredentialResourceCollection($this->credentials()->get()),
            'works'=> new WorksResourceCollection($this->works()->get()),
            'languages'=> new UserLanguagesResourceCollection($this->languages()->get()),
            'services'=> new UserServiceResourceCollection($this->userService()->get()),
            'schedule'=> new UserScheduleResourceCollection($schedules),
            'chat_free' => $this->chat_free,
            'online' => $this->online || $this->scheduleActiveNow(),
            'reading_in_progress' => $this->is_reading_in_progress(),
            'favorite' => $this->isSaved(),

        ];
    }
}
