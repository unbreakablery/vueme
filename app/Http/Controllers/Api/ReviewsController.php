<?php

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 8/23/2019
 * Time: 11:27 AM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AppointmentWriteReviewResource;
use App\Http\Resources\v1\PostFrontResource;
use App\Http\Resources\v1\PostResource;
use App\Http\Resources\v1\ReviewBasicResourceCollection;
use App\Http\Resources\v1\ReviewReplyBasicResource;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Services\ApiUtils;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class ReviewsController extends Controller
{


    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api')->except(['write_review_from_email', 'getReviewsByPsychic']);
        $this->auth = $auth;
    }



    protected function filterReviews(Request $request)
    {


        $q = Review::where('psychic_id', '=', Auth::guard('api')->user()->id);
        if ($request->has('status') && !is_null($request->input('status')) && $request->input('status') != 'All') {
            $status = explode(',', $request->input('status'));
            $q->whereIn('status', $status);
        }
        if ($request->has('date_filter') && !is_null($request->input('date_filter')) && $request->input('date_filter') != 'All') {
            $dayAfter = (new \DateTime('now'))->modify('-' . $request->input('date_filter') . ' months')->format('Y-m-d');

            $q->whereDate('created_at', '>=', $dayAfter);
        }

        $q->orderBy('created_at', 'desc');
        return $q->get();
    }

    protected function filterUserReviews(Request $request)
    {


        $q = Review::where('user_id', '=', Auth::guard('api')->user()->id);
        if ($request->has('status') && !is_null($request->input('status')) && $request->input('status') != 'All') {
            $status = explode(',', $request->input('status'));
            $q->whereIn('status', $status);
        }
        if ($request->has('date_filter') && !is_null($request->input('date_filter')) && $request->input('date_filter') != 'All') {
            $dayAfter = (new \DateTime('now'))->modify('-' . $request->input('date_filter') . ' months')->format('Y-m-d');

            $q->whereDate('created_at', '>=', $dayAfter);
        }

        $q->orderBy('created_at', 'desc');
        return $q->get();
    }


    public function getReviews(Request $request)
    {

        $reviews = new ReviewBasicResourceCollection($this->filterReviews($request));

        return $reviews;
    }

    public function getUserReviews(Request $request)
    {

        $reviews = new ReviewBasicResourceCollection($this->filterUserReviews($request));

        return $reviews;
    }

    public function getReviewsByPsychic(Request $request)
    {
        $q = Review::where('psychic_id', $request->id)->where('status', 'Posted');


        if ($request->has('filter') && !is_null($request->input('filter')) && $request->input('filter') == 'Helpful') {
            $q->orderBy('helpful', 'desc');
        } elseif ($request->has('filter') && !is_null($request->input('filter')) && $request->input('filter') == 'Oldest') {
            $q->orderBy('created_at', 'asc');
        } else {
            $q->orderBy('created_at', 'desc');
        }


        return ($perPage = $request->get('per_page')) ? new ReviewBasicResourceCollection($q->paginate($perPage)) : $q->get();
    }

    public function saveReply(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
            'text' => 'required|string',
        ]);



        $user = Auth::user();
        $id =  $request->input('id');
        $text =  $request->input('text');


        $review = $user->reviews()->where('id', '=', $id)->first();

        if (is_null($review)) {
            return response()->json(['message' => 'Invalid review ID'], 400);
        }

        $reply = new ReviewReply();
        $reply->text = $text;
        $reply->psychic_id = $user->id;
        $reply->review_id = $review->id;
        $reply->status = "Pending";
        $reply->save();

        return response()->json(['message' => 'Reply sent', 'reply' => new ReviewReplyBasicResource($reply)], 200);
    }

    public function editUserReview(Request $request)
    {


        $this->validate($request, [
            'id' => 'required|integer',
            'title' =>  'required|string',
            'text' =>  'required|string',
            'rating' =>  'required|integer',
        ]);



        $user = Auth::user();
        $id =  $request->input('id');
        $title =  $request->input('title');
        $text =  $request->input('text');
        $rating =  $request->input('rating');



        $review = $user->user_reviews()->where('id', '=', $id)->where('status', '=', 'Pending')->first();

        if (is_null($review)) {
            return response()->json(['message' => 'Invalid review ID'], 400);
        }


        $review->text = $text;
        $review->title = $title;
        $review->rating = $rating;
        $review->save();

        return response()->json(['message' => 'Review updated'], 200);
    }

    public function createReview(Request $request)
    {


        $this->validate($request, [
            'headline' =>  'required|string',
            'text' =>  'required|string',
            'rating' =>  'required|integer|min:1',
            'psychic' =>  'required|integer',
            // 'category' =>  'required|integer',
            // 'service' =>  'required|integer',
            // 'appointment' =>  'required|integer',
        ]);


        $user = Auth::user();
        $psychic_id =  $request->input('psychic');
        $category_id =  $request->input('category');
        $service_id =  $request->input('service');
        $title =  $request->input('headline');
        $text =  $request->input('text');
        $rating =  $request->input('rating');
        $appointment_id = $request->input('appointment');

        if ($appointment_id) {
            $appointment = $user->user_appointments()->where('id', '=', $appointment_id)->where('status', '=', 'Completed')->first();
            // if(is_null($appointment)){
            //     return response()->json(['message'=> 'Invalid appointment ID'], 400);
            // }
            $appointment->reviewed = true;
            $appointment->save();
        }



        $review = new Review();
        $review->text = $text;
        $review->title = $title;
        $review->rating = $rating;
        $review->user_id = $user->id;
        $review->psychic_id = $psychic_id;
        $review->category_id = $category_id;
        $review->service_id = $service_id;
        $review->save();

        return response()->json(['message' => 'Thank you for leaving a review.'], 200);
    }
    public function write_review_from_email(Request $request)
    {

        $this->validate($request, [
            'headline' =>  'required|string',
            'text' =>  'required|string',
            'rating' =>  'required|integer|min:1',
            'token' =>  'required|string',
            'appointment' =>  'required|integer',
        ]);

        $appointment = Appointment::where([
            ['id', '=', $request->appointment],
            ['token_review', '=', $request->token],
            ['reviewed', '=', 0],
            ['status', '=', 'Completed']
        ])->first();



        if (!$appointment) {
            return $this->response_fail('Not Allowed', 400);
        }

        $review = new Review();
        $review->text = $request->text;
        $review->title = $request->headline;
        $review->rating = $request->rating;
        $review->user_id = $appointment->user_id;
        $review->psychic_id = $appointment->psychic_id;
        $review->category_id = $appointment->category_id;
        $review->service_id = $appointment->service_id;
        $review->save();

        $appointment->reviewed = true;
        $appointment->save();
        //EmailUtils::send_email_to_psychic_when_received_review($appointment->psychic()->first());

        return ApiUtils::response_success('Review sent', 200);
    }
}
