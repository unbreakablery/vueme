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

    .height-center td {
      padding: 70px 11px;
    }

    .show-sm {
      display: none ;
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
            <tr height="20"></tr>
            <tr>
              <td width="30%" style="text-align:center;background: #EFF6FF;">
              <a href="{{config('app.url')}}">
                <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="159" height="38"/>
              </a>
              </td>
            </tr>
          <![endif]-->  
      <tr>
        <td class="padding-sm"
          style="padding-top: 36px;background:#EFF6FF;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto; display: block;">
          <!--[if !gte mso 9]> -->
          <a href="{{config('app.url')}}">
            <img src="{{config('app.url')}}/images/site-images/logo_black.png" width="159"
              style="margin-top: 30px" />
            </a>
             <!--<![endif]-->  
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
            <div style="margin-top: 36px; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 18px; font-weight: 600;color:#43425D;">
              It Pays to Play by these Rules
            </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
            <div style="line-height: 1.5;margin:auto; margin-top: 30px; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 16px; color:#656B72; max-width: 550px; padding: 0px 15px">
              In order to ensure Respectfully is lucrative for you and a great experience for clients, here’s the basics:
            </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
          <img style="margin-top: 35px;border-radius: 50%;" src="{{config('app.url')}}/images/site-images/24_hour_after_register_1.png" width="120"
            height="120" />
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
            <div style="margin-top: 20px; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; font-weight: 600;color:#43425D;">
              When You’re Online…
            </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
            <div style="line-height: 1.5;margin:auto; margin-top: 20px; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 16px; color:#656B72; max-width: 550px; padding: 0px 15px">
              Make sure you stick to the response time rules - don’t miss an opportunity to earn! If you miss too many requests, your profile visibility gets downgraded which means less money in your pocket.
            </div>
        </td>
      </tr>

      <tr>
        <td style="text-align: center; background:#EFF6FF">
          <img style="margin-top: 35px;border-radius: 50%;" src="{{config('app.url')}}/images/site-images/24_hour_after_register_2.png" width="120"
            height="120" />
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
            <div style="margin-top: 20px; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; font-weight: 600;color:#43425D;">
              When You Get a New Client Request…
            </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background:#EFF6FF">
            <div style="line-height: 1.5;margin:auto; margin-top: 20px; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 16px; color:#656B72; max-width: 550px; padding: 0px 15px">
              Online? Respond in 30 minutes. In a reading? Respond in 2 hours. Offline? Respond in 24 hours.
            </div>
        </td>
      </tr>      
            
      <tr>
        <td
          style="height: 38px;padding-top: 50px;padding-bottom: 50px; background:#EFF6FF;text-align: center; color: #43425D;font-family: sans-serif; font-size: 14px; margin: auto; display: block;">

          <div style="height: 38px;">
            <!--[if !gte mso 9]> -->
            <a style="font-weight: 600; width: 124px; height: 38px; padding: 10px 20px; background-color: #43425D; border-radius: 20px; color:white; font-size: 14px;font-family: 'Montserrat', 'Verdana', sans-serif;"
            href="https://respectfully.zendesk.com/hc/en-us/articles/360045794071-Online-Offline-Response-Time-Rules-" target="blank">
            Full Details
          </a>
           <!--<![endif]--> 
            <!--[if gte mso 9]>
                 <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://respectfully.zendesk.com/hc/en-us/articles/360045794071-Online-Offline-Response-Time-Rules-" style="height:38px;v-text-anchor:middle;width:120px;" arcsize="60%" opacity="0" stroke="f" fillcolor="#43425D">
                  <w:anchorlock/>
                   <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">
                  Full Details            
                  </center>
               </v:roundrect>
            <![endif]--> 
          </div>
        </td>
      </tr>
      <tr>
        <td
          style="height: 38px;background:#8EBEF8;text-align: center;font-family: sans-serif; font-size: 14px; margin: auto; display: block;">
          <div style="margin:auto; text-align: center;  font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 14px; font-weight: 600; color:#FFFFFF; max-width: 550px; padding: 10px 15px">
            <a target="blank" style="color: #FFFFFF; font-family: 'Montserrat', 'Verdana', sans-serif;" href="https://respectfully.zendesk.com/hc/en-us/articles/360045794071-Online-Offline-Response-Time-Rules-">Tap Here to Visit Our Help Center for Tips!</a>
        </div>
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