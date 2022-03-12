<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <!-- Tell iOS not to automatically link certain text strings. -->
  <meta name="color-scheme" content="light">
  <meta name="supported-color-schemes" content="light">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
  <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
  <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

  <!-- Web Font / @font-face : BEGIN -->
  <!-- NOTE: If web fonts are not required, lines 23 - 41 can be safely removed. -->

  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
  <!--[if mso]>
        <style>
            * {
                font-family: 'Montserrat', 'Verdana', sans-serif !important;
            }
        </style>
    <![endif]-->

  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
  <!--[if !mso]><!-->

  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
  <!--<![endif]-->

  <!-- Web Font / @font-face : END -->

  <!-- CSS Reset : BEGIN -->
  <style>
    * {
      font-family: 'Montserrat', sans-serif;
    }

    /* What it does: Tells the email client that only light styles are provided but the client can transform them to dark. A duplicate of meta color-scheme meta tag above. */
    :root {
      color-scheme: light;
      supported-color-schemes: light;
    }

    /* What it does: Remove spaces around the email design added by some email clients. */
    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
    html,
    body {
      margin: 0 auto !important;
      padding: 0 !important;
      height: 100% !important;
      width: 100% !important;
    }

    /* What it does: Stops email clients resizing small text. */
    * {
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%;
    }

    /* What it does: Centers email on Android 4.4 */
    div[style*="margin: 16px 0"] {
      margin: 0 !important;
    }

    /* What it does: forces Samsung Android mail clients to use the entire viewport */
    #MessageViewBody,
    #MessageWebViewDiv {
      width: 100% !important;
    }

    /* What it does: Stops Outlook from adding extra spacing to tables. */
    table,
    td {
      mso-table-lspace: 0pt !important;
      mso-table-rspace: 0pt !important;
    }

    /* What it does: Replaces default bold style. */
    th {
      font-weight: normal;
    }

    /* What it does: Fixes webkit padding issue. */
    table {
      border-spacing: 0 !important;
      border-collapse: collapse !important;
      table-layout: fixed !important;
      margin: 0 auto !important;
    }

    /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
    a {
      text-decoration: none;
    }

    /* What it does: Uses a better rendering method when resizing images in IE. */
    img {
      -ms-interpolation-mode: bicubic;
    }

    /* What it does: A work-around for email clients meddling in triggered links. */
    a[x-apple-data-detectors],
    /* iOS */
    .unstyle-auto-detected-links a,
    .aBn {
      border-bottom: 0 !important;
      cursor: default !important;
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    /* What it does: Prevents Gmail from changing the text color in conversation threads. */
    .im {
      color: inherit !important;
    }

    /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
    .a6S {
      display: none !important;
      opacity: 0.01 !important;
    }

    /* If the above doesn't work, add a .g-img class to any image in question. */
    img.g-img+div {
      display: none !important;
    }

    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
    /* Create one of these media queries for each additional viewport size you'd like to fix */

    /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
      u~div .email-container {
        min-width: 320px !important;
      }
    }

    /* iPhone 6, 6S, 7, 8, and X */
    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
      u~div .email-container {
        min-width: 375px !important;
      }
    }

    /* iPhone 6+, 7+, and 8+ */
    @media only screen and (min-device-width: 414px) {
      u~div .email-container {
        min-width: 414px !important;
      }
    }
  </style>
  <!-- CSS Reset : END -->

  <!-- Progressive Enhancements : BEGIN -->
  <style>
    /* What it does: Hover styles for buttons */
    .button-td,
    .button-a {
      transition: all 100ms ease-in;
    }

    .button-td-primary:hover,
    .button-a-primary:hover {
      background: #555555 !important;
      border-color: #555555 !important;
    }

    .content-left {
      width: 136px;
    }

    .padding-sm {
      padding: 0px 20px;
      padding-top: 28px
    }

    .height-center td {
      padding: 70px 11px;
    }

    .show-sm {
      display: none;
    }

    /* Media Queries */
    @media screen and (max-width: 750px) {



      .content-left {
        width: 100%;
        min-width: 100%;
        display: block;
      }

      .show-sm {
        display: inline !important;
      }

      .show-sm {
        display: inline-block !important;
      }

      .hidden-sm {
        display: none !important;
      }

      .content-right {
        display: block;
      }

      .padding-sm {
        padding: 0px 20px;
        padding-top: 28px
      }

      .email-container {
        width: 100% !important;
        margin: auto !important;
      }

      /* What it does: Forces table cells into full-width rows. */
      .stack-column,
      .stack-column-center {
        /* display: block !important; */
        display: inline;
        width: 50% !important;
        max-width: 100% !important;
        direction: ltr !important;
      }

      /* And center justify these ones. */
      .stack-column-center {
        text-align: center !important;
      }

      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
      .center-on-narrow {
        text-align: center !important;
        display: block !important;
        margin-left: auto !important;
        margin-right: auto !important;
        float: none !important;
      }

      table.center-on-narrow {
        display: inline !important;
      }

      /* What it does: Adjust typography on small screens to improve readability */
      .email-container p {
        font-size: 17px !important;
      }
    }
  </style>
  <!-- Progressive Enhancements : END -->

</head>
<!--
	The email background color (#222222) is defined in three places:
	1. body tag: for most email clients
	2. center tag: for Gmail and Inbox mobile apps and web versions of Gmail, GSuite, Inbox, Yahoo, AOL, Libero, Comcast, freenet, Mail.ru, Orange.fr
	3. mso conditional: For Windows 10 Mail
-->

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; ">
  <center role="article" aria-roledescription="email" lang="en" style="width: 100%;">

    <!-- Preview Text Spacing Hack : END -->

    <!-- Email Body : BEGIN -->
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="750"
      style="margin: auto;" class="email-container">

      <!-- Email Header : END -->

      <!-- Hero Image, Flush : BEGIN -->
      <!--[if gte mso 9]>
            <tr style="background: #F0F0F7;" height="40"></tr>
            <tr>
              <td width="30%" style="text-align:center;background: #F0F0F7;">
              <a href="{{config('app.url')}}">
                <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="165" height="46"/>
              </a>
              </td>
            </tr>                
          <![endif]-->
      <tr>
        <td class="padding-sm"
          style="background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; line-height: 15px; margin: auto; display: block;">
          <!--[if !gte mso 9]> -->
          <a href="{{config('app.url')}}">
            <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="165" height="46.56" />
          </a>
          <!--[endif]-->
          <div
            style="letter-spacing: 0.36px; text-transform: capitalize; margin:auto; margin-top: 36px; text-align: center; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 18px; font-weight: 600;color:#43425D; text-align: center;">
            <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">Featured Model</div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#F0F0F7">
          <!--[if gte mso 9]>
                <table>
                  <tr>
                    <td width="20%"></td>
                     <td width="60%">
                     <v:oval style="width:180;height:180;opacity:0;" stroked="false">
                     <v:fill src="{{$psychic->userProfile->haedshot_path}}" type="frame">
                    <v:/fill>
                   </v:oval>
                   </td>
                    <td width="20%"></td>
                  </tr>
                 </table>
                 <![endif]-->
          <!--[if !gte mso 9]> -->
          {{-- <img style="margin-top: 30px;border-radius: 50%;" src="{{$psychic->userProfile->haedshot_path}}"
          width="180"
          height="180" /> --}}
          <div style="background:url('{{$psychic->userProfile->haedshot_path}}');
            border-radius: 50%;
  width: 180px;
  height: 180px;
  background-size: cover; margin: auto; margin-top: 30px;"></div>
          <!--<![endif]-->
        </td>
      </tr>
      <tr>
        <td
          style="padding-top: 10px; background:#F0F0F7;text-align: center; color: #9D61BD; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 18px; font-weight: 600; margin: auto; display: block;">
          {{$psychic->userProfile->display_name}}
        </td>
      </tr>
      <tr>
        <td
          style="padding-top: 10px; background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; margin: auto; display: block;">
          <table cellspacing="0" width="100%">
            <tr>
              <td style="text-align: right">
                <img src="{{config('app.url')}}/images/site-images/five_stars.png" height="15" /></td>
              <td style="text-align: left">
                <span
                  style="opacity: 0.5; margin-left: 10px; font-weight: 500; font-family: 'Montserrat', 'Verdana', sans-serif;">{{$psychic->reviews->count()}}
                  Reviews</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr>
        <td
          style="padding-top: 20px; background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; margin: auto; display: block;">
          <div
            style="max-width: 440px; margin: auto;text-align: center; padding: 0px 15px; font-weight: 500; font-family: 'Montserrat', 'Verdana', sans-serif;">
            @foreach ($psychic->categories as $category)
            @if ($loop->first)
            {{$category->name}}
            @else
            {{' • '.$category->name}}
            @endif
            @endforeach
          </div>
        </td>
      </tr>
      <tr>
        <td
          style="padding-top: 20px; background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; margin: auto; display: block;">

          <div
            style="max-width: 440px; margin: auto;text-align: center; padding: 0px 15px; font-family: 'Montserrat', 'Verdana', sans-serif;">
            {{$psychic->userProfile->elevator_pitch ?? $psychic->userProfile->tagline ?? (strlen($psychic->user_profile->description) < 160 ? $psychic->user_profile->description : substr($psychic->user_profile->description, 0, 160) . '...')}}
          </div>
        </td>
      </tr>
      <tr>
        <td
          style="padding-top: 30px; padding-bottom: 8px; background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; margin: auto; display: block;">
          <!--[if !gte mso 9]> -->
          <a style="font-weight: 600; width: 124px; height: 38px; padding: 10px 20px; background-color: #43425D; border-radius: 20px; color:white; font-size: 14px; font-family: 'Montserrat', 'Verdana', sans-serif;"
            href="{{config('app.url')}}/{{$psychic->userProfile->profile_link}}" target="blank">
            Contact Me
          </a>
          <!--<![endif]-->
          <!--[if gte mso 9]>
                 <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}/{{$psychic->userProfile->profile_link}}" style="height:38px;v-text-anchor:middle;width:124px;" arcsize="60%" opacity="0" stroke="f" fillcolor="#43425D;">
                  <w:anchorlock/>
                   <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">
                  Contact Me                 
               </center>
               </v:roundrect>
              <![endif]-->
        </td>
      </tr>
      <!--[if gte mso 9]>
      <tr width="100%" height="30" style="background:#F0F0F7;"></tr>
      <![endif]-->
      <tr>
        <!--[if gte mso 9]>  
      <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" 
        style="width: 750px; height: 189px;">
        <v:fill type="tile" src="{{config('app.url')}}/images/site-images/featured_email.png" color="#333333" />   
        <v:textbox inset="0,0,0,0">                                 
      <![endif]-->
        <td
          style="padding-top: 30px; background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; margin: auto; display: block">

          <div
            style="background-image: url('{{config('app.url')}}/images/site-images/featured_email.png'); height: 189px; background-size: cover; background-repeat: no-repeat;background-position: center;">

            <div style="padding-top: 53px; padding-bottom: 53px;">
              <div
                style="color:#43425D; font-size: 18px; font-weight: 600; max-width: 440px; margin: auto;text-align: center; padding: 0px 15px; font-family: 'Montserrat', 'Verdana', sans-serif;">
                Seeking Clarity? Try Our Top Models!</div>

              <div style="margin-top: 35px;">
                <!--[if !gte mso 9]> -->
                <a style="border: 1px solid #43425D; font-weight: 600; width: 124px; height: 38px; padding: 10px 20px; background-color: transparent; border-radius: 20px; color:#43425D; font-size: 14px; font-family: 'Montserrat', 'Verdana', sans-serif;"
                  href="{{config('app.url')}}" target="blank">
                  Explore Now
                </a>
                <!--<![endif]-->
              </div>
            </div>
          </div>
        </td>
        <!--[if gte mso 9]>
        </v:textbox>
        </v:rect>
      <![endif]-->
      </tr>
      <!--[if gte mso 9]>              
              <tr align="center" style="background: #F0F0F7;" width="100%" style="text-align:center;">
              <table width="100%">
              <tr>
              <td width="40%"></td>
              <td width="20%">
              <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}" style="height:40px;v-text-anchor:middle;width:134px;text-align:center;" arcsize="60%" stroke="t" strokecolor="#43425D" fillcollor="#F0F0F7">
              <w:anchorlock/>
              <center style="color:#43425D;font-family:sans-serif;font-size:14px;font-weight:bold;">
              Explore Now               
              </center>
              </v:roundrect>
              </td>
              <td width="40%"></td>
              </tr>
              </table>
              <tr>
            <![endif]-->
      <!--[if gte mso 9]>
                <tr style="background: #F0F0F7;" width="100%" height="20"></tr>             
            <![endif]-->
      <tr>
        <td
          style="background-color: #43425D;line-height: 24px; text-align: center; margin: auto;  font-family: 'Montserrat', 'Verdana', sans-serif; color: #FFFFFF;font-size: 16px;">
          <div style="max-width: 550px; margin: auto; padding: 0px 35px;">
            <table cellspacing="0" width="100%">
              <tr>
                  <td
                      style="text-align: center; padding-top: 30px; color: #8EBEF8; font-family: 'Montserrat', 'Verdana', sans-serif; font-weight: 600; font-size: 16px;">
                      <div class="hidden-sm" style="font-family: 'Montserrat', 'Verdana', sans-serif;">
                          Read the Latest
                          Model News on Our Radar</div>
                      <div class="show-sm">
                          <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">Read the Latest
                          </div>
                          <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">Model News on
                              Our Radar</div>
                      </div>
                  </td>
              </tr>
              <tr>
                  <td
                      style="text-align: center;padding-top:20px; color: #ffffff; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 16px;">
                      <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">
                          Check out our <a
                              style=" color: #8EBEF8;font-family: 'Montserrat', 'Verdana', sans-serif;"
                              href="https://www.respectfully.com/blog">New Age Blog</a>
                          for the best spiritual and wellness stories, news and advice.
                      </div>
                  </td>
              </tr>

              <tr>
                  <td>
                      <table style="margin-top: 35px !important;" role="presentation" border="0"
                          cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                              <td style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                                  class="center-on-narrow">

                                  <hr style="width:180px;margin-bottom: 19px;">

                                  <a href="https://www.instagram.com/respectfully/" target="blank">
                                      <img src="{{config('app.url')}}/images/icons/email/instagram_2.png">
                                  </a>
                                  <a href="https://www.facebook.com/Respectfully/" target="blank"
                                      style="margin-left:14px;">
                                      <img src="{{config('app.url')}}/images/icons/email/facebook_2.png">

                                  </a>
                                  <a href="https://twitter.com/respectfully/" target="blank"
                                      style="margin-left:14px;">
                                      <img class="padding_social"
                                          src="{{config('app.url')}}/images/icons/email/twitter_2.png">
                                  </a>
                                  <a href="https://www.linkedin.com/company/respectfully/about/"
                                      target="blank" style="margin-left:14px;">
                                      <img src="{{config('app.url')}}/images/icons/email/linkedin_2.png">
                                  </a>


                              </td>
                          </tr>
                          <tr>
                              <td
                                  style="font-family: 'Montserrat', 'Verdana', sans-serif; padding-top:15px; padding-bottom: 20px; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff!important;">
                                  <a href="mailto:{{$user->email}}"> <span
                                          style="color:#FFFFFF !important; font-family: 'Montserrat', 'Verdana', sans-serif;">Sent to <span
                                              style="color:#8EBEF8">{!!
                                              str_replace('.', '<span>.</span>', str_replace('@',
                                              '<span>@</span>', $user->email))
                                              !!}</span></a> because you joined our platform.
                                  <br>
                                  © Copyright 2020 <a target="_blank" href="VueMe.com"><span
                                          style="color:#8EBEF8"><span style="font-family: 'Montserrat', 'Verdana', sans-serif;">VueMe.</span>com</span></a>,
                                  LLC</span>
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>

            </table>
          </div>
        </td>
      </tr>

    </table>
  </center>
</body>

</html>