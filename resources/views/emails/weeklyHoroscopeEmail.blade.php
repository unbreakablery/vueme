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
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
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
                font-family: sans-serif !important;
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

    .show-sm {
      display: none;
    }

    /* Media Queries */
    @media screen and (max-width: 750px) {

      .show-sm {
        display: block !important;
      }

      .hidden-sm {
        display: none !important;
      }

      /* .content-left {
        width: 100%;
        min-width: 100%;
        display: block;
      } */
      .content-left {
        width: 98px
      }

      .content-left img{
        width: 65px;
        height: 65px;
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
          <!-- Hero Image, Flush : BEGIN -->
          <!--[if gte mso 9]>   
            <table width="30" style="background: #F0F0F7;">
            <tr height="30"></tr>
            </table> 
            <tr>
              <td width="30%" style="text-align:center;background: #F0F0F7;">
              <a href="{{config('app.url')}}">
                <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="165" height="46.56"/>
              </a>
              </td>
            </tr>
             <table width="30" style="background: #F0F0F7;">
            <tr height="30"></tr>
            </table> 
          <![endif]--> 
      <tr>
        <td class="padding-sm"
          style="padding-top: 0px;background:#F0F0F7;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto; display: block;">
           <!--[if !gte mso 9]> -->
          <a href="{{config('app.url')}}">
            <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="165" height="46.56"
              style="margin-top: 37px" />
          </a>
          <!--<![endif]-->  
          <div
          style="height: 120px; margin:auto; margin-top: 36px; text-align: center; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 18px; font-weight: 600;color:white; text-align: center;">
          <table width="100%"><tr>
              <!--[if gte mso 9]>  
      <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" 
        style="width: 710px; height: 120px;">
        <v:fill type="tile" src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email.png" color="#333333" />   
        <v:textbox inset="0,0,0,0">                                        
      <![endif]-->
          <td class="padding-sm" style="background:url('{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email.png'); background-size: cover; height: 120px; padding-top: 0px">
         <!--[if gte mso 9]> 
          <table width="100%"><tr height="40"></tr><tr><td width="264"></td><td width="186">
          <![endif]-->
            <div style="padding: 53px 0px;"><span style="color:#FFFFFF;font-family: 'Montserrat', 'Verdana', sans-serif;text-align:center;font-weight:bold;font-size: 18px;">Weekly Horoscope</span></div>
          <!--[if gte mso 9]> 
          </td><td width="264"><td><tr></table>
          <![endif]-->
          </td>
      <!--[if gte mso 9]>
        </v:textbox>
        </v:rect>
      <![endif]-->
        </tr></table>
        </div>
        </td>
      </tr>
     

      <tr>
        <td class="padding-sm"
          style="padding-top: 0px;background:#F0F0F7;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto; display: block;">
          <div
            style="line-height: 1.5; margin:auto; padding-top: 25px; text-align: center; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 16px;color:#43425D; text-align: center;">
            <div style="0px">Visit our expert astrologers for a live reading!</div>
          </div>
          <div style="padding-top: 42px">
            <!--[if !gte mso 9]> -->
            <a style="width: 114px; height: 38px; padding: 10px 20px; background-color: #8EBEF8; border-radius: 20px; color:white; font-size: 14px;font-family: 'Montserrat', 'Verdana', sans-serif; font-weight: 600"
              href="{{config('app.url')}}" target="blank">
              Visit Now
            </a>
            <!--<![endif]-->  
            <!--[if gte mso 9]>
            <table width="100%"><tr height="20"></tr></table>
            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}" style="height:38px;v-text-anchor:middle;width:108px;" arcsize="60%" opacity="0" stroke="f" fillcolor="#8EBEF8">
            <w:anchorlock/>
            <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">
            Visit Now            
            </center>
            </v:roundrect>
            <![endif]--> 
          </div>
        </td>
      </tr>

      @for ($i = 0; $i < 6; $i++) <tr>
        <td class="padding-sm"
          style=" height: 115px; background:#F0F0F7;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto;">
          <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
            height="100%">
            <tr>
              @if ($i == 0)              
              <td class="content-left"
                style="background:url('{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email3.png');background-size: cover; background-repeat: no-repeat;">
                <!--[if gte mso 9]>
                <table>
                  <tr>
                    <td width="20%"></td>
                     <td width="60%">
                     <v:oval style="width:83;height:83;opacity:0;" stroked="false">
                     <v:fill src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email{{$images[$i]}}.png" type="frame">
                    <v:/fill>
                   </v:oval>
                   </td>
                    <td width="20%"></td>
                  </tr>
                 </table>
                    <![endif]--> 
                <!--[if !gte mso 9]> -->
                <img src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email{{$images[$i]}}.png"
                  width="83" height="83" />
                <!--<![endif]-->   
              </td>
              @else
              <td class="content-left" style="background: {{$backgrounds[$i]}}">
                <!--[if gte mso 9]>
                <table>
                  <tr>
                    <td width="20%"></td>
                     <td width="60%">
                     <v:oval style="width:83;height:83;opacity:0;" stroked="false">
                     <v:fill src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email{{$images[$i]}}.png" type="frame">
                    <v:/fill>
                   </v:oval>
                   </td>
                    <td width="20%"></td>
                  </tr>
                 </table>
                    <![endif]--> 
                <!--[if !gte mso 9]> -->
                <img src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email{{$images[$i]}}.png"
                  width="83" height="83" />
                  <!--<![endif]-->
              </td>
              @endif
              <td class="content-right" style="background-color: #FFFFFF; text-align: left; padding: 15px">
                <span style="color: #9D61BD; font-size: 16px; font-weight: 600">{{$signs[$i]['name']}}</span><span
                  style="color: #9D61BD; font-size: 14px; margin-left:10px;">{{$dates[$i]}}</span>
                <div style="font-size: 14px; line-height: 21px; margin: 0px; padding: 14px 0px">
                  {{$signs[$i]['text']}}
                </div>
              </td>
            </tr>
          </table>
        </td>
        </tr>
        @endfor
        <td class="padding-sm"
          style=" height: auto;background:#F0F0F7;text-align: center; color: #9759FF;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto;;">

          <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
            class="center-table">
            <tr>
              <td class="content-right"
                style="text-align: center; ">
                <a href="{{config('app.url')}}/search?sortBy=rating" target="blank">
                  {{-- background:url('{{config('app.url')}}/images/site-images/horoscope_email/horoscope.png');background-size: cover; background-repeat: no-repeat;  --}}
                  <img class="show-sm" src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope2.png"
                  width="100%" />

                  <img class="hidden-sm" src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope.png"
                  width="100%" />
                  {{-- <p
                    style="line-height: 2; font-size: 16px; font-weight: 600; margin: 0px; color: #43425D;text-align: center">
                    Seeking Clarity?
                  </p>
                  <p
                    style="line-height: 2; font-size: 16px; font-weight: 600; margin: 0px; color: #43425D;text-align: center">
                    Try Our Top Models!
                  </p>
                  <div style="padding-top: 32px">

                    <a style="width: 114px; height: 38px; padding: 10px 20px; background-color: #43425D; border-radius: 20px; color:white; font-size: 14px;font-family: 'Montserrat', 'Verdana', sans-serif; font-weight: 600"
                      href="{{config('app.url')}}/search?sortBy=rating" target="blank">
                      Explore
                    </a>
                  </div> --}}
                </a>
              </td>
            </tr>
          </table>
        </td>
        </tr>
        @for ($i = 6; $i < 12; $i++) <tr>
          <td class="padding-sm"
            style=" height: 115px; background:#F0F0F7;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto;">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
              height="100%">
              <tr>
                <td class="content-left" style="background: {{$backgrounds[$i]}}">
                   <!--[if gte mso 9]>
                <table>
                  <tr>
                    <td width="20%"></td>
                     <td width="60%">
                     <v:oval style="width:83;height:83;opacity:0;" stroked="false">
                     <v:fill src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email{{$images[$i]}}.png" type="frame">
                    <v:/fill>
                   </v:oval>
                   </td>
                    <td width="20%"></td>
                  </tr>
                 </table>
                    <![endif]--> 
                <!--[if !gte mso 9]> -->
                  <img src="{{config('app.url')}}/images/site-images/horoscope_email/horoscope_email{{$images[$i]}}.png"
                    width="83" height="83" />
                    <!--<![endif]-->
                </td>
                <td class="content-right" style="background-color: #FFFFFF; text-align: left; padding: 15px">
                  <span style="color: #9D61BD; font-size: 16px; font-weight: 600">{{$signs[$i]['name']}}</span><span
                    style="color: #9D61BD; font-size: 14px; margin-left:10px;">{{$dates[$i]}}</span>
                  <div style="font-size: 14px; line-height: 21px; margin: 0px; padding: 14px 0px">
                    {{$signs[$i]['text']}}
                  </div>
                </td>
              </tr>
            </table>
          </td>
          </tr>
          @endfor
          <tr>
            <td style="height: 30px; background:#F0F0F7; width: 100%"></td>
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
                            © Copyright 2021 <a target="_blank" href="VueMe.com"><span
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
          <!-- Thumbnail Left, Text Right : END -->

    </table>
  </center>
</body>

</html>