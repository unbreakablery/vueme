@include('emails.base')
    <!-- Email Body : BEGIN -->
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: auto;" class="email-container">
        <!-- Email Header : BEGIN -->
        @include('emails.header', [
        'title' => 'Now Go Enjoy the View',
         'avatar' => $model->userProfile->haedshot_path,
         'subtitle' => 'Thanks for Subscribing, Babe!',
         'text' => 'Curious just how thankful she is? Log in and see...'
         ]) 
    </table>

    <div style="padding: 40px;background-color:#E6E5F7;">

     <div style="color: #9D9BB4; text-align: left;">
      {{$created->format('m-d-Y')}} Order Summary
     </div>
    <div style="border: 1px solid #D8D7E2;margin-top: 10px;"></div>

    <div style="color: #FF6888; text-align: left;margin-top: 30px;margin-bottom: 10px;">
     <label style="font-size: 13px">SUBSCRIPTION</label>
     <label style="float: right;font-size: 13px">PER MONTH</label>
    </div>
    <div style="color: #9D9BB4; text-align: left;">
     <label>{{$model->userProfile->display_name}}</label>
     <label style="float: right;">$ {{$subscription->price}}</label>
    </div>
    <div style="border: 1px solid #D8D7E2;margin-top: 10px;"></div>

    <div style="color: #9D9BB4; text-align: right">
     <div style="color: #FF6888; margin-top: 30px;margin-bottom: 10px;font-size: 13px">
      ORDER TOTAL $ {{$subscription->price}}
     </div>
     <div style=" margin-top: 10px;">RENEWS ON {{$renew}}</div>
     </div>
    </div>

    <table>
        <tr>
            <td dir="ltr" valign="top" style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: grey; padding: 40px" class="center-on-narrow">
              <a href="{{ route('specialtie.profile', ['display_name' => $model->userProfile->profile_link]) }}" style="color: white; padding: 10px 50px !important;font-size: 0.99rem !important; background-color: #777591; border-radius: 20px;text-decoration: none;">
              Show Me
              </a>
            </td>
        </tr>

    </table>

@include('emails.footer')
