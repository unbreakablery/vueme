<?php

use App\Models\Country_all;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post('/stream/on_publish', 'LiveStreamController@on_publish');

/* Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend'); */

Route::prefix('v1')->group(function () {

    Route::post('login', 'Api\AuthController@postLogin')->name('login');
    // Route::post('register', 'Api\AuthController@postRegister')->name('register');
    // Route::post('register/user', 'Api\AuthController@userRegister')->name('register_user');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('getUser', 'Api\AuthController@getUser')->name('getUser');
    });

    Route::post('verify/referral', 'Api\AuthController@verifyReferral')->name('verify_referral');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('getUser', 'Api\AuthController@getUser')->name('getUser');
    });

    Route::get('user/verify/{token}', 'Api\AccountController@verifyUser')->name('user/verify/{token}');


    /* Payment  */
    Route::post('user/account/validate','Api\AccountController@validate_apple_session')->name('user.validate_apple');
    Route::post('user/account/apple/pay','Api\AccountController@pay_with_apple')->name('user.apple_pay');
    Route::post('user/validate/promo','Api\AccountController@validate_promo_code')->name('user.add_card');
    Route::post('user/account/card','Api\AccountController@save_card')->name('user.add_card');
    Route::put('user/account/card','Api\AccountController@update_card_priority')->name('user.update_card');
    Route::delete('user/account/card','Api\AccountController@delete_card')->name('user.delete_card');
    Route::post('user/account/depositAccount','Api\AccountController@save_deposit_account')->name('user.add_deposit_account');
    Route::post('user/account/paypal','Api\AccountController@save_paypal_account')->name('user.paypal');
    Route::delete('user/account/paypal','Api\AccountController@delete_paypal_account')->name('delete.paypal');
    Route::post('user/header/info','Api\AccountController@set_login_counter')->name('user.remove.header.info');



    Route::post('user/account/cardPayment','Api\AccountController@save_card_payment')->name('user.save_card_payment');
    Route::post('user/account/cardSubscribe','Api\AccountController@save_card_subscribe')->name('user.save_card_subscribe');
    Route::get('user/account/cards','Api\AccountController@get_cards_user')->name('user.cards');
    Route::post('user/account/credits','Api\AccountController@buy_credits')->name('user.buy_credits');
    Route::post('user/account/subscribe','Api\AccountController@subscribe')->name('user.subscribe');
    Route::put('user/account/payout','Api\AccountController@edit_deposit_account')->name('psychic.edit.deposit');
    
     /* End Payment  */


    Route::get('user/profile','Api\AccountController@profile')->name('user/profile');
    Route::post('user/profile/save','Api\AccountController@saveProfile')->name('user/profile/save');
    Route::post('basicuser/profile/save','Api\AccountController@saveUserProfile')->name('basicuser/profile/save');
    Route::post('user/profile/credential/delete/{id}','Api\AccountController@deleteCredential')->name('user/profile/delete/credential');
    Route::post('user/profile/work/delete/{id}','Api\AccountController@deleteWork')->name('user/profile/delete/work');
    Route::post('user/profile/language/delete/{id}','Api\AccountController@deleteLanguage')->name('user/profile/delete/language');
    

    Route::post('user/profile/images/save','Api\AccountController@saveProfileImages')->name('user/profile/save');
    // Route::post('user/profile/image/upload','Api\AccountController@uploadProfileImage')->name('user/profile/image/upload');
    // Route::post('user/profile/cover/upload','Api\AccountController@uploadProfileCover')->name('user/profile/cover/upload');
    Route::post('user/profile/video/upload','Api\AccountController@uploadProfileVideo')->name('user/profile/video/upload');
    Route::post('user/profile/audio/upload','Api\AccountController@uploadProfileAudio')->name('user/profile/audio/upload');

    Route::get('user/services','Api\UserServicesController@get')->name('user/services');
    Route::get('user/suscription','Api\PsychicController@getSubscription')->name('user/suscription');
    Route::post('user/services/save','Api\UserServicesController@save')->name('user/services/save');
    Route::post('user/suscription/save','Api\PsychicController@saveSubscription')->name('user/suscription/save');    
    Route::get('user/schedule','Api\UserScheduleController@get')->name('user/schedule');
    Route::post('user/schedule/save','Api\UserScheduleController@save')->name('user/schedule/save');

    Route::get('psychic/reviews','Api\ReviewsController@getReviews')->name('psychic/reviews');
    Route::get('psychic/subscribers','Api\PsychicController@modelSubscriptions')->name('psychic/subscribers'); 
    Route::post('psychic/block-user','Api\PsychicController@blockUser')->name('psychic/block_user'); 
    Route::get('psychic/reviews_by_psychic','Api\ReviewsController@getReviewsByPsychic')->name('psychic/reviews_by_psychic');
    Route::get('user/reviews','Api\ReviewsController@getUserReviews')->name('user/reviews');
    Route::get('psychic/appointment/{id}','Api\AppointmentController@getAppointment')->name('psychic/appointment');
    Route::get('psychic/appointments','Api\AppointmentController@getAppointments')->name('psychic/appointments');
    Route::get('model/appointments_on_day','Api\AppointmentController@getAppointmentsDay')->name('model/appointments_on_day');
    Route::post('psychic/appointment/update/status','Api\AppointmentController@updateAppointmentStatus')->name('psychic/appointment/update/status');
    Route::post('psychic/appointment/edit/data','Api\AppointmentController@editAppointment')->name('psychic/appointment/edit/data');
    Route::post('psychic/appointment/edit/notes', 'Api\AppointmentController@editAppointmentNotes')->name('user/appointment/edit/notes');
    Route::post('psychic/reviews/reply/save','Api\ReviewsController@saveReply')->name('psychic/reviews/reply/save');
    Route::post('user/review/create','Api\ReviewsController@createReview')->name('user/review/create');
    Route::get('user/appointments','Api\AppointmentController@getUserAppointments')->name('user/appointments');
    Route::get('user/appointments-month','Api\AppointmentController@getAppointmentsMonth')->name('appointments_month');
    Route::post('user/appointment/create', 'Api\AppointmentController@createAppointment')->name('user/appointment/create');
    Route::post('user/private/create', 'Api\AppointmentController@createPrivateShow')->name('user/appointment/create/private');
    Route::post('user/appointment/edit/data', 'Api\AppointmentController@editUserAppointment')->name('user/appointment/edit/data');
    Route::post('user/appointment/update/status', 'Api\AppointmentController@updateUserAppointmentStatus')->name('user/appointment/update/status');
    Route::post('user/review/update/data', 'Api\ReviewsController@editUserReview')->name('user/review/update/data');
    Route::post('psychic/request/review', 'Api\AppointmentController@requestReview')->name('psychic/request/review');
    Route::post('/review/email/create', 'Api\ReviewsController@write_review_from_email')->name('from_email_write_review');
    Route::put('/user/opinion', 'Api\UserController@sent_opinion_after_service')->name('opinion.sent');


    //search routes
    Route::get('search/models', 'Api\SearchController@getPsychics')->name('models');

    // Route::get('search/psychic/profile/{id}', 'Api\SearchController@getPsychic')->name('getPsychic_profile');

    Route::get('search/favorites', 'Api\SearchController@getFavorites')->name('favorites');
    Route::get('model/schedule', 'Api\UtilController@getModelSchedule')->name('model_schedule');
    Route::get('search/model/{id}', 'Api\SearchController@getModel')->name('model');
    Route::get('find/models', 'Api\SearchController@getModelsSearch')->name('model_search');
    Route::get('search/post/{id}', 'Api\SearchController@getPost')->name('post');
    Route::get('search/categories/{slug?}', 'Api\SearchController@getCategories')->name('categories');
    Route::get('search/horoscopesign/{slug?}', 'Api\SearchController@getHoroscopesign')->name('horoscopesign');
    

    Route::post('search/horoscopeinfo','Api\SearchController@getHoroscopeInfo')->name('horoscopeinfo');
    Route::get('search/weeks', 'Api\SearchController@getWeeks')->name('signs');


    Route::get('search/horoscopeuser/{slug?}', 'Api\SearchController@getUserHoroscope')->name('horoscopeuser');
    Route::get('search/specialties/{slug?}', 'Api\SearchController@getSpecialties')->name('get_specialties');
    Route::post('search/home', 'Api\SearchController@search')->name('search');
    
    Route::any('/user/vchat/available', 'Api\UserController@vchat_available');
    Route::any('/user/vchat/request/{model_id}/{service_id}/', 'Api\UserController@vchat_request');
    Route::any('/user/vchat/request/{model_id}/{service_id}/{appointment_id}', 'Api\UserController@vchat_request_with_appointment');
    Route::any('/user/vchat/request_cancel/{model_id}', 'Api\UserController@vchat_request_cancel');
    Route::any('/user/vchat/end/{user_chat_room_id}', 'Api\UserController@vchat_end');
    Route::any('/user/vchat/extend/{user_chat_room_id}/{minutes}', 'Api\UserController@vchat_extend');
    Route::any('/model/vchat/start/{chat_request_id}', 'Api\UserController@model_vchat_start');
    Route::any('/model/vchat/end/{star_chat_room_id}', 'Api\UserController@model_vchat_end');
    Route::any('/model/vchat/request_cancel/{chat_request_id}', 'Api\UserController@model_vchat_request_cancel');
    Route::any('/broadcast', 'Api\UserController@broadcast');

    Route::post('user/save/favorite', 'Api\UserController@saveFavorite')->name('user.saveFavorite');
    Route::get('/user/myfavorities', 'Api\UserController@getfavoritiessuer')->name('getfavoritiessuer');
    Route::post('send-tip','Api\UserController@sendTip')->name('user.sendTip');
    Route::post('user/save/helpfuls', 'Api\UserController@saveHelpfuls')->name('user.saveHelpfuls');

    //Text chat
    Route::get('user/chat/message/{user}', 'Api\ChatController@index')->name('user.chat');
    Route::get('user/chat/active', 'Api\ChatController@users')->name('user.users');
    Route::post('user/chat/message', 'Api\ChatController@store')->name('user.post_message');
    Route::put('user/chat/message/{chat}', 'Api\ChatController@update')->name('user.read.message');
    Route::put('user/chat/{user}', 'Api\ChatController@user_chat_leave')->name('user.leave.chat');
    Route::get('user/chat/notifications', 'Api\ChatController@get_notifications')->name('user.chat.notifications');
    Route::get('user/chat/smessages', 'Api\ChatController@get_search_messages')->name('user.chat.search.messages');
    Route::get('user/chat/messages', 'Api\ChatController@get_messages_from_search')->name('user.chat.search.messages');
    Route::get('user/chat/start', 'Api\ChatController@check_first_message')->name('user.chat.check_first_message');
    Route::post('user/chat/start', 'Api\ChatController@save_first_message')->name('user.chat.save_first_message');
    Route::put('notifications/remove', 'Api\UserController@removeNotifications')->name('remove_notifications');
    Route::get('notifications', 'Api\UserController@getNotifications')->name('notifications');
     
    


    Route::get('user/transactions', 'Api\UserController@user_credit_logs')->name('user.transactions');
    Route::get('user/analytics/overview', 'Api\AnalyticsController@get_psychic_overview_analytic')->name('psychic.overview');
    Route::get('user/analytics/stream', 'Api\AnalyticsController@get_psychic_stream_analytic')->name('psychic.stream');
    Route::get('user/analytics/income', 'Api\AnalyticsController@get_psychic_income_analytic')->name('psychic.income');
    Route::get('user/analytics/earnings', 'Api\AnalyticsController@get_psychic_earnings_analytic')->name('psychic.earnings');
    Route::put('user/psychic/account', 'Api\PsychicController@UpdatePsychic')->name('psychic.update');
    
    Route::get('user/hdata','Api\AnalyticsController@header_data_earning_reviews_views')->name('psychic.header.data');
    Route::post('user/set_contact_status','Api\AccountController@set_contact_status')->name('psychic.set.account.status');
    Route::post('user/verify/update/phone','Api\PhoneVerificationController@addAndVerifyPhoneNumber')->name('add_verify_phone');
    Route::post('user/verify/phone/code','Api\PhoneVerificationController@verifyCode')->name('verify_phone');
    Route::post('user/verify/phone/validate/{id}','Api\PhoneVerificationController@validateInvalidate')->name('validate_invalidate');
    Route::post('user/resend/phone/code','Api\PhoneVerificationController@sendSms')->name('resend_phone_code');
    Route::post('user/referral/send', 'Api\PsychicController@referralEmail')->name('referralEmail');
    Route::post('user/referral/resend', 'Api\PsychicController@referralEmailResend')->name('referralEmailResend');
    Route::get('user/get/credits', 'Api\UserController@credits')->name('get_user_credits');


    Route::post('pusher/auth', 'Api\AccountController@pusher_authorizer')->name('puther_auth');

    Route::get('/services/list', function () {
            return response()->json(\App\Models\Services::all());
        })->name('admin.services');

    Route::get('blog/get_post_next_and_prev', 'Api\UtilController@getPostNextAndPrev')->name('get_post_next_and_prev');   
    
    Route::post('specialist/channel', 'Api\StreamController@create_channel')->name('create_channel');
    Route::put( 'specialist/channel/{channel}/end', 'Api\StreamController@end_channel')->name('end_channel');
    Route::put( 'specialist/channel/{channel}/collect', 'Api\StreamController@collect_channel')->name('collect_channel');
    Route::put( 'user/channel/{channel}/collect', 'Api\StreamController@collect_channel_user')->name('collect_channel_user');
    Route::post('webhook/live', 'Api\PusherController@webhook_live')->name('webhook_live');

});


Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/agency/users', 'Api\AdminController@getUsers')->name('admin.users');
    Route::get('/agency/horoscope-config', 'Api\HoroscopeController@getHoroscopeConfig')->name('admin.getHoroscopeConfig');

        Route::post('/agency/horoscope/save', 'Api\HoroscopeController@saveHoroscopeConfig')->name('admin.saveHoroscopeConfig');

        Route::post('/agency/horoscope/signs', 'Api\HoroscopeController@saveHoroscopeSigns')->name('admin.getHoroscopeSigns');
        Route::post('/agency/horoscopeinfo/save', 'Api\HoroscopeController@saveHoroscopeInfo')->name('admin.horoscopeinfo.save');        
        Route::post('/agency/horoscopeinfo/update', 'Api\HoroscopeController@updateHoroscopeInfo')->name('admin.horoscopeinfo.update');       

        Route::post('/agency/archive-horoscopeinfo', 'Api\HoroscopeController@archiveHoroscopeInfo')->name('admin.horoscopeinfo.update');        
        
        Route::delete('/agency/delete-horoscopeinfo/{id}', 'Api\HoroscopeController@deleteHoroscopeInfo')->name('admin.horoscopeinfo.delete');
        Route::delete('/agency/delete-horoscopeuser/{id}', 'Api\HoroscopeController@deleteUserHoroscope')->name('admin.horoscopeuser.delete');

        Route::post('/agency/horoscope/send/email', 'Api\HoroscopeController@sendEmail')->name('admin.sendEmail');
        Route::post('/agency/horoscope/send/sign-email/{id}', 'Api\HoroscopeController@sendSignEmail')->name('admin.sendSignEmail');
        


    Route::prefix('admin')->group(function () {

        

        Route::delete('/user/{id}', 'Api\AdminController@deleteUser')->name('admin.users.delete');

        Route::get('/roles', function () {
            return new \App\Http\Resources\v1\RoleResourseCollection(\App\Models\Role::withTrashed()->get());
        })->name('admin.roles');

        Route::put('/update-category/{id?}', 'Api\AdminController@updateCategory')->name('admin.category.update');

        Route::get('/services-list', 'Api\AdminController@getUsersService')->name('admin.services-list');

        

        Route::get('/email/top-rate-config', 'Api\EmailController@getTopRateConfig')->name('admin.getTopRateConfig');

        Route::get('/email/user-select', 'Api\EmailController@getUserForSelect')->name('admin.getUserForSelect');

        Route::post('/email/save/top-rate-config', 'Api\EmailController@saveTopRateConfig')->name('admin.saveTopRateConfig');

        Route::post('/email/send/top-rate', 'Api\EmailController@sendEmailTopRate')->name('admin.sendEmailTopRate');

        Route::get('/email/featured-config', 'Api\EmailController@getFeaturedConfig')->name('admin.getFeaturedConfig');

        Route::post('/email/save/featured-config', 'Api\EmailController@saveFeaturedConfig')->name('admin.saveFeaturedConfig');

        Route::post('/email/send/featured', 'Api\EmailController@sendEmailFeatured')->name('admin.sendEmailFeatured');

        Route::get('/promos', 'Api\PromoBuyCreditController@list')->name('admin.promo.list');

        Route::post('/promo', 'Api\PromoBuyCreditController@save')->name('admin.promo.save');

        Route::delete('/promo/{id}', 'Api\PromoBuyCreditController@delete')->name('admin.promo.delete');

        Route::put('/update-service/{id}', 'Api\AdminController@updateService')->name('admin.category.update');

        Route::put('/update-user/{id}', 'Api\AdminController@updateUser')->name('admin.user.update');

        Route::get('/payout', 'Api\AdminController@payouts')->name('admin.payouts');

        Route::get('/payoutpending', 'Api\AdminController@getPayoutsPendingInfo')->name('admin.payouts');
        Route::get('/psychic/payoutsinfo', 'Api\AdminController@getPayoutsPaidInfo')->name('admin.payoutsinfo');
        Route::get('/psychic/transactions', 'Api\AdminController@getTransactionsPaidInfo')->name('admin.payoutsinfo');
        

        Route::any('/review', 'Api\AdminController@reviews')->name('admin.reviews');

        Route::post('/payout-init-email/{id}', 'Api\AdminController@payoutInitEmail')->name('admin.payout.init.email');

        Route::get('/paymentinfo', 'Api\AdminController@getPaymentInfo')->name('admin.paymentinfo');

        Route::get('/transaction', 'Api\AdminController@transactions')->name('admin.transactions');

        Route::post('/retract/transaction/{id}', 'Api\AdminController@retractTransaction')->name('admin.retract.transaction');

        Route::post('/refund/account', 'Api\AdminController@refundAccount')->name('admin.refund.account');

        // Route::get('/transaction-detail/{id}', 'Api\AdminController@transactionsDetail')->name('admin.transactions');

        Route::get('/chat', 'Api\AdminController@chat')->name('admin.chat');

        Route::get('/chat-messages/{user1}/{user2}', 'Api\AdminController@chatMessages')->name('admin.chatMessages');

        Route::get('/countries', 'Api\AdminController@countries')->name('admin.country_all');

        Route::prefix('analytic')->group(function () {

            Route::post('/sign-up', 'Api\AdminController@signUp')->name('admin.signUp');

            Route::post('/user-status', 'Api\AdminController@userStatus')->name('admin.userStatus');

            Route::post('/services', 'Api\AdminController@servicesAnalytic')->name('admin.servicesAnalytic');

            Route::post('/payouts', 'Api\AdminController@payoutAnalytic')->name('admin.payoutAnalytic');

            Route::post('/transactions', 'Api\AdminController@transactionAnalytic')->name('admin.transactionAnalytic');

            Route::get('/ltv', 'Api\AdminController@ltvAnalytic')->name('admin.ltvAnalytic');
        });

        Route::get('/country-code', function(){
            return Country_all::select('code2', 'country')->orderBy('country', 'asc')->get();
        })->name('get_country_code');
        
    });
});

