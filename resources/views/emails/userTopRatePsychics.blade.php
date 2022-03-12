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
                font-family: 'Montserrat', 'Verdana', sans-serif
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
      font-family: 'Montserrat', 'Verdana', sans-serif
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

       .name-width {
        width: 200px;
        height: 40px; padding: 12px 0px;}

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
      <tr>
        <td class="padding-sm"
          style="background:#F0F0F7;text-align: center; color: #43425D;font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; line-height: 15px; margin: auto; display: block;">
          <!--[if gte mso 9]>
         <table width="100%"><tr height="50"></tr></table>
         <![endif]-->
          <a href="{{config('app.url')}}">
            <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="165" height="46.56" />
          </a>
          <div
            style=" line-height: 12px; letter-spacing: 0.36px; text-transform: capitalize; margin:auto; margin-top: 36px; text-align: center; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px; font-weight: 600;color:#43425D; text-align: center;">
            <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">See what everyone is saying</div>
            <div style="padding-top: 15px;padding-bottom: 5px; font-family: 'Montserrat', 'Verdana', sans-serif;">About these top-rated models!</div>
          </div>
        </td>
      </tr>
      @foreach ($users as $user1)
      @php
      $review = \App\Models\Review::find($user1->review);// $user1->reviews()->orderBy('rating', 'desc')->first();
      $reviews = $user1->reviews()->count();
      @endphp
      <tr>
        <td class="padding-sm"
          style=" height: 115px; background:#F0F0F7;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto;">
          <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
            height="100%">
            <tr>
              <td class="content-left hidden-sm"
                style="background: #D8E4F7; vertical-align: top; padding-top: 20px; padding-bottom: 15px; text-align: center">
                <!--[if gte mso 9]>
                <table>
                  <tr>
                    <td width="20%"></td>
                     <td width="60%">
                     <v:oval style="width:85;height:85;opacity:0;" stroked="false">
                     <v:fill src="{{$user1->userProfile->haedshot_path}}" type="frame">
                    <v:/fill>
                   </v:oval>
                   </td>
                    <td width="20%"></td>
                  </tr>
                 </table>
                    <![endif]-->
                <!--[if !gte mso 9]> -->
                {{-- <img src="{{$user1->userProfile->haedshot_path}}" width="95" height="95" style="border-radius: 50%;" /> --}}
                <div style="background:url('{{$user1->userProfile->haedshot_path}}');
                  border-radius: 50%;
        width: 95px;
        height: 95px;
        background-size: cover; border-radius: 50%; margin: auto"></div>
                <!--<![endif]-->
              </td>
              <td class="content-right"
                style="background-color: #FFFFFF; text-align: left; padding: 20px;">

                <div
                  style="color: #43425D; font-size: 16px; font-weight: 600; font-family: 'Montserrat',  'Verdana', sans-serif;">
                  <div style="padding-right: 10px; float: left;" class="show-sm">
                    {{-- <img src="{{$user1->userProfile->haedshot_path}}"
                    width="60" height="60" style="border-radius: 50%;" /> --}}
                    <div style="background:url('{{$user1->userProfile->haedshot_path}}');
                        border-radius: 50%;
              width: 60px;
              height: 60px;
              background-size: cover; border-radius: 50%; display: inline; display: inline-block"></div>
                  </div>
                  <div class="name-width"
                    style="display: inline-block; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px;">
                    <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">{{$user1->userProfile->display_name}}
                    </div>
                    <div class="show-sm" style="margin-top: 5px;"><span
                        style="font-weight: 500; color: #43425D; opacity: 0.5; font-size: 12px;font-family: 'Montserrat',  'Verdana', sans-serif;">{{$reviews}}
                        Reviews
                      </span></div>
                  </div>
                </div>
                <div style="color: #9D61BD; font-size: 14px; padding-top: 11px">
                  <span
                    style="color: #656B72; font-size: 12px; font-weight: 600; font-family: 'Montserrat',  'Verdana', sans-serif; padding-right: 10px">
                    {{$review->title}}
                  </span>
                  @for ($i = 0; $i < $review->rating; $i++)
                    <img src="{{config('app.url')}}/images/site-images/star.png" width="15" height="14.27"
                      style="margin-right: 3px" />
                    @endfor
                    {{-- <span class="hidden-sm"
                      style="font-weight: 500; color: #43425D; opacity: 0.5; padding-left: 12px; font-size: 12px;font-family: 'Montserrat',  'Verdana', sans-serif;">{{$reviews}}
                      Reviews
                    </span> --}}
                </div>
                <div
                  style="font-size: 12px; color: #656b72; line-height: 21px; margin: 0px; padding: 14px 0px ;font-family: 'Montserrat', 'Verdana', sans-serif;">
                  “{{$review->text}}” - {{$review->user->userProfile->name}}
                </div>
                <div style="font-size: 12px; text-align: right; color: white;">
                  <!--[if !gte mso 9]> -->
                  <a style="font-weight: 600; display: inline-block; padding: 10px 20px; padding-right: 5px; background-color: #8EBEF8; border-radius: 20px; color:white; font-size: 12px; font-family: 'Montserrat',  'Verdana', sans-serif;"
                    href="{{config('app.url')}}/{{$user1->userProfile->profile_link}}" target="blank">
                    <span style="font-family: 'Montserrat', 'Verdana', sans-serif;">Profile</span> <img style="padding: 0px 8px;"
                      src="{{config('app.url')}}/images/site-images/top_rate_email.png" />
                  </a>
                  <!--<![endif]-->
                  <!--[if gte mso 9]>
                 <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}/{{$user1->userProfile->profile_link}}" style="height:35px;v-text-anchor:middle;width:92px;" arcsize="60%" opacity="0" stroke="f" fillcolor="#8EBEF8">
                  <w:anchorlock/>
                   <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">
                  Profile
                  <img style="padding: 0px 8px;" src="{{config('app.url')}}/images/site-images/top_rate_email.png" />
               </center>
               </v:roundrect>
                   <![endif]-->
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      @endforeach
      <tr>
        <td>
          <div style="height: 30px; background:#F0F0F7; width: 100%"></div>
        </td>
      </tr>
      <tr>
        <td
          style="background-color: #43425D;line-height: 24px; text-align: center; margin: auto;  font-family: 'Montserrat',  'Verdana', sans-serif; color: #FFFFFF;font-size: 16px;">
          <div style="max-width: 550px; margin: auto; padding: 0px 35px;">
            <table cellspacing="0" width="100%">
              <tr>
                <td
                  style="text-align: center; padding-top: 30px; color: #8EBEF8; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 16px;">
                  <div style="font-family: 'Montserrat',  'Verdana', sans-serif;" class="hidden-sm">Read the Latest Model News on Our Radar</div>
                  <div style="font-family: 'Montserrat',  'Verdana', sans-serif;" class="show-sm">
                    <div>Read the Latest</div>
                    <div>Model News on Our Radar</div>
                  </div>
                </td>
              </tr>
              <tr>
                <td
                  style="text-align: center;padding-top:20px; color: #ffffff; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px;">
                  <div style="font-family: 'Montserrat',  'Verdana', sans-serif;">
                    Check out our <a style=" color: #8EBEF8;font-family: 'Montserrat',  'Verdana', sans-serif;"
                      href="https://www.respectfully.com/blog">New Age Blog</a>
                    for the best spiritual and wellness stories, news and advice.
                  </div>
                </td>
              </tr>

              <tr>
                <td>
                  <table style="margin-top: 35px !important;" role="presentation" border="0" cellpadding="0"
                    cellspacing="0" width="100%">
                    <tr>
                      <td
                        style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                        class="center-on-narrow">

                        <hr style="width:180px;margin-bottom: 19px;">

                        <a href="https://www.instagram.com/respectfully/" target="blank">
                          <img src="{{config('app.url')}}/images/icons/email/instagram_2.png">
                        </a>
                        <a href="https://www.facebook.com/Respectfully/" target="blank" style="margin-left:14px;">
                          <img src="{{config('app.url')}}/images/icons/email/facebook_2.png">

                        </a>
                        <a href="https://twitter.com/respectfully/" target="blank" style="margin-left:14px;">
                          <img class="padding_social" src="{{config('app.url')}}/images/icons/email/twitter_2.png">
                        </a>
                        <a href="https://www.linkedin.com/company/respectfully/about/" target="blank"
                          style="margin-left:14px;">
                          <img src="{{config('app.url')}}/images/icons/email/linkedin_2.png">
                        </a>


                      </td>
                    </tr>
                    <tr>
                      <td
                        style="font-family: 'Montserrat',  'Verdana', sans-serif; padding-top:15px; padding-bottom: 20px; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff!important;">
                        <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">
                          <a href="mailto:{{$user->email}}"> <span style="color:#FFFFFF !important; font-family: 'Montserrat', 'Verdana', sans-serif; ">Sent to <span
                              style="color:#8EBEF8; font-family: 'Montserrat', 'Verdana', sans-serif;">{!!
                              str_replace('.', '<span>.</span>', str_replace('@', '<span>@</span>', $user->email))
                              !!}</span></a> because you joined our platform.
                        <br>
                        © Copyright 2020 <a target="_blank" href="VueMe.com"><span
                            style="color:#8EBEF8; font-family: 'Montserrat', 'Verdana', sans-serif;"><span style="font-family: 'Montserrat', 'Verdana', sans-serif;">VueMe.</span>com</span></a>, LLC</span>
                        </div>
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