@include('emails.header2')
    
<tr>
  <td align="center" valign="top">
    <div style="color: #76757E; font-size: 18px; margin-top: 30px; font-family: 'Work Sans', sans-serif;">REFER CLIENTS,</div>
    <div style="color: #131220; font-size: 40px; font-weight: 700; margin-bottom: 30px; margin-top: 10px; font-family: 'Work Sans', sans-serif;">Get Rewarded</div>
</td>
</tr>
<tr>
  <td align="center" valign="top">
    <div style="font-weight: 600; padding: 20px 0px; font-size: 18px; margin-top: 10px; background-color: #D5BDFF; color: white; text-align: center; font-family: 'Work Sans', sans-serif;">Participate In Our Referral Program</div>
</td>
</tr>
<tr>
  <td align="center" valign="top">
    <div style="color: #949498; font-size: 14px; margin-top: 30px; font-weight: 600">Recruit More, Make More</div>
    <div style="line-height: 24px; color: #131220; font-size: 16px; max-width: 570px; margin: auto; padding: 0px 15px; margin-bottom: 30px; margin-top: 20px; font-family: 'Work Sans', sans-serif;">
      We want to help you for helping us. If a fan signs up to Respectfully through an invite you send them, we’ll give you a 5% finder’s fee of whatever a fans spends for their first purchase on the site whether or not they spend it on you!
    </div>
</td>
</tr>

<tr>
  <td align="center" valign="top">
    <div style="color: #949498; font-size: 14px;font-weight: 600; font-family: 'Work Sans', sans-serif;">Get Started</div>
    <div style="line-height: 24px; color: #131220; font-size: 16px; max-width: 570px; margin: auto; padding: 0px 15px; margin-bottom: 30px; margin-top: 20px; font-family: 'Work Sans', sans-serif;">
      Check out the referral program in your dashboard. Quick access to this feature is located in your account and sidebar menus.
    </div>
</td>
</tr>

<tr>
  <td dir="ltr" valign="top" style="font-family: 'Work Sans', sans-serif; font-size: 15px; line-height: 20px; color: grey; padding: 40px; padding-top:0px; text-align: center" class="center-on-narrow">
    <a href="{{ route('dashboard_referrals') }}" style="color: white; padding: 10px 20px !important;font-size: 12px !important; background: transparent linear-gradient(256deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
      box-shadow: 0px 2px 4px #9759FF4D; border-radius: 10px;text-decoration: none; font-weight: 600;">
    Go to Referrals Tab
    </a>
  </td>
</tr>



@include('emails.footer2')
