@include('emails.header2')
    
<tr>
  <td align="center" valign="top">
    <div style="color: #2A2A37; font-size: 18px; font-weight: 700; margin: 40px 0px;">Let Your Talents Pay Off</div>
</td>
</tr>
<tr>
  <td align="center" valign="top" style="text-align: center">
    <div style="color: #66666F; font-size: 16px; font-weight: 500; max-width: 570px; margin: auto; padding: 0px 20px">
      Ready to effortlessly share your talents with the world? Together, we’ll build your thriving online business. Now that your account is ready, let’s prepare your profile for launch. Log in now to fully complete your profile.
    </div>
  </td>
</tr>
<td align="center" valign="top" style="text-align: center">
  <div style="margin: auto; padding-top: 30px">
    <img src="{{config('app.url')}}/images/site-images/wellcome-email1.png" width="120" height="110">
  </div>
  <div style="margin: auto; padding-top: 5px; color: #A2A2A5; font-size: 16px; font-weight: 600">
    Profile Photo
  </div>
  <div style="max-width: 570px; margin: auto; padding: 0px 20px; margin: auto; padding-top: 20px; color: #66666F; font-size: 16px; font-weight: 500">
    Find your favorite headshot to show the world the face behind the magic.
  </div>
</td>
</tr>

</tr>
<td align="center" valign="top" style="text-align: center">
  <div style="margin: auto; padding-top: 30px">
    <img src="{{config('app.url')}}/images/site-images/wellcome-email2.png" width="120" height="110">
  </div>
  <div style="margin: auto; padding-top: 5px; color: #A2A2A5; font-size: 16px; font-weight: 600">
    About
  </div>
  <div style="max-width: 570px; margin: auto; padding: 0px 20px; margin: auto; padding-top: 20px; color: #66666F; font-size: 16px; font-weight: 500">
    Tell the world about your personality and what you love to do for clients in livestreams and private sessions.
  </div>
</td>
</tr>

</tr>
<td align="center" valign="top" style="text-align: center">
  <div style="margin: auto; padding-top: 30px">
    <img src="{{config('app.url')}}/images/site-images/wellcome-email3.png" width="120" height="110">
  </div>
  <div style="margin: auto; padding-top: 5px; color: #A2A2A5; font-size: 16px; font-weight: 600">
    Prices & Services
  </div>
  <div style="max-width: 570px; margin: auto; padding: 0px 20px; margin: auto; padding-top: 20px; color: #66666F; font-size: 16px; font-weight: 500">
    Let your current and future fans know what you charge for subscriptions, livestreams and private sessions.
  </div>
</td>
</tr>

<tr>
  <td dir="ltr" valign="top" style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: grey; padding: 40px; text-align: center" class="center-on-narrow">
    <a href="{{ route('psychic_profile') }}" style="color: white; padding: 10px 50px !important;font-size: 0.99rem !important; background: transparent linear-gradient(256deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
      box-shadow: 0px 2px 4px #9759FF4D; border-radius: 20px;text-decoration: none; font-weight: 500;">
    Edit Profile
    </a>
  </td>
</tr>



@include('emails.footer2')
