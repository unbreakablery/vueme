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
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    </style>
    <style>
        * {
            font-family: 'Montserrat', 'Verdana', sans-serif;
        }
    </style>
    <style>
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Montserrat', 'Verdana', sans-serif;
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

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
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
            .text_review{
                width: 100% !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
        }

        a {
            cursor: pointer;
        }
        .padding_social{
                padding: 0px 10px !important;
        }
        .checked {
            color: orange;
            }
    </style>

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

        /* Media Queries */
        @media screen and (max-width: 600px) {

            h1 {
                font-size: 25px !important;
            }

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
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
            .text_review{
                width: 100% !important;
            }
          
           
        }
    </style>

    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Prevent WebKit and Windows mobile changing default text sizes */
        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /* Remove spacing between tables in Outlook 2007 and up */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
    </style>

</head>
    <body width="100%"
    style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #ffffff;font-family: 'Montserrat', 'Verdana', sans-serif;">
    <div style="width: 100%; background-color: #ffffff;">
        <div style="background-color: #45519B;margin: auto; width: 600px; text-align:center">
            <div style="padding:20px 0px;padding-top:50px">
                <a href="{{config('app.url')}}"> <img src="{{config('app.url')}}/images/site-images/logo.png"  width="159" alt="alt_text" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;"></a>
            </div>
            <div style="padding:50px 0px; padding-bottom:15px">
                <h1 style="margin: 0 0 10px; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 28px; line-height: 42px; color: #ffffff; font-weight: normal;">
                   We’ve added $10 to your account
                </h1>
            </div>
            <div style="padding:0px 20px;">
            <div style="margin: auto;font-family: 'Montserrat', 'Verdana', sans-serif; color: #D3C9C3;font-size: 14px;max-width: 450px;">
            Treat yourself to clarity with our gift to you! Find the perfect Model and take $10 off your reading.
            </div>
            </div>
            <div style="padding:50px 0px;">
                <!--[if !gte mso 9]> -->
                <a href="{{config('app.url')}}">                    
                <button type="button" style="cursor:pointer; height: 36px;min-width: 64px;padding: 0 35px; background-color: #8EBEF8; font-size:14px;border-radius: 28px;border: 0px;color: #ffff;">
                    <span class="v-btn__content">Use Now</span>
                </button>
                </a>
                <!--<![endif]-->  
                <!--[if gte mso 9]>
                <table width="100%" style="background-color: #45519B"><tr height="20"></tr></table>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}" style="height:38px;v-text-anchor:middle;width:132px;" arcsize="60%" opacity="0" stroke="f" fillcolor="#9daff9">
                <w:anchorlock/>
                <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">
                Use Now                                               
                </center>
                </v:roundrect>
                <![endif]-->
            </div>
            <div style="padding:50px 0px;">
                <img src="{{config('app.url')}}/images/site-images/10gift.png" />
            </div>
        </div>        
    </div>
    <center style="width: 100%; background-color: #ffffff;">
    <!--[if !gte mso 9]> -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
            style="margin: auto;background-color: #45519B" class="email-container">
    <!--[endif]-->
            <!--[if gte mso 9]>
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
            style="margin: auto;background-color: #45519B" class="email-container">                
    <![endif]-->    
            <tr>
                <td dir="ltr" width="100%" style="padding: 10px;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td>
                        <table style="margin-top: 50px !important;" role="presentation" border="0" cellpadding="0"
                          cellspacing="0" width="100%">
                          <!--[if !gte mso 9]> -->
                          <tr>
                            <td dir="ltr" valign="top"
                              style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                              class="center-on-narrow">
                              <a href="https://www.instagram.com/respectfully/" target="blank" class="ml-45">
                                <img src="{{config('app.url')}}/images/icons/email/instagram2.png">
                              </a>                            
                              <a href="https://www.facebook.com/Respectfully/" target="blank" class="ml-45" style="margin-left:10px;">
                                <img src="{{config('app.url')}}/images/icons/email/facebook2.png">
                              </a>
                              <a href="https://twitter.com/respectfully/" target="blank"  class="ml-45">
                                <img class="padding_social" src="{{config('app.url')}}/images/icons/email/twitter2.png">
                              </a>
                              <a href="https://www.linkedin.com/company/respectfully/about/" target="blank"  class="ml-45">
                                <img src="{{config('app.url')}}/images/icons/email/linkedin2.png">
                              </a>
                              <div style="width:50%; border-top: 1px solid #C7C7C7; margin: auto; margin-top: 20px;"></div>
                             </td>
                          </tr>
                          <!--[endif]-->
                         <!--[if gte mso 9]>
                          <tr height="50"></tr>
                          <tr width="100%">
                            <td width="25%"></td>
                            <td width="12.5%"
                              style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                              class="center-on-narrow">
                            <a href="https://www.instagram.com/respectfully/" target="blank" >
                                <img src="{{config('app.url')}}/images/icons/email/instagram2.png">
                            </a>  
                            </td>
                            <td width="12.5%"
                              style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                              class="center-on-narrow">
                            <a href="https://www.facebook.com/Respectfully/" target="blank" style="margin-left:45px;">
                                <img src="{{config('app.url')}}/images/icons/email/facebook2.png">
                            </a>
                            </td>
                            <td width="12.5%"
                              style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                              class="center-on-narrow">
                              <a href="https://twitter.com/respectfully/" target="blank"  class="ml-45">
                                <img class="padding_social" src="{{config('app.url')}}/images/icons/email/twitter2.png">
                              </a>                         
                            </td>
                            <td width="12.5%"
                              style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                              class="center-on-narrow">
                              <a href="https://www.linkedin.com/company/respectfully/about/" target="blank"  class="ml-45">
                                <img src="{{config('app.url')}}/images/icons/email/linkedin2.png">
                              </a>                
                            </td>
                            <td width="25%"></td>
                           </tr>
                          <tr height="20" width="100%"></tr>  
                        <![endif]-->     
                        </table>
                      </td>
                    </tr>
                    <!--[if gte mso 9]>        
                    <tr>
                      <table style="margin-top: 50px !important;" role="presentation" border="0" cellpadding="0"
                      cellspacing="0" width="100%">
                      <tr>
                      <td width="25%"></td>
                      <td width="50%" style="border-top: 1px solid #C7C7C7;"></td>
                      <td width="25%"></td>
                      </tr>
                    </table>
                    </tr>                      
                    <![endif]--> 
                    <tr>
                      <td
                        style="font-family: 'Montserrat', 'Verdana', sans-serif;padding: 20px; font-size: 12px; line-height: 15px; text-align: center; color: #C7C7C7 !important;">
                        <p style="color:#C7C7C7;text-align: center;">This email was sent to {{$user->email}}  because you joined our platform.
                        <br><br>
                         © 2020 Respectfully™. Respectfully™ is a federally registered trademark.</p>
                      </td>
                    </tr>
                  </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>