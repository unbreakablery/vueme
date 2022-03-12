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
    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
    <style>
        * {
            font-family: 'Verdana', sans-serif !important;
        }
    </style>
    <![endif]-->


    <!--[if !mso]><!-->
    <!-- insert web font reference, eg:  -->
    <style>
        * {
            font-family: 'Montserrat', 'Verdana', sans-serif;
        }
    </style>
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
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

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

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
    <!--[if gte mso 12]>
    <style type="text/css">
        .mso-right {
            padding-left: 20px;
        }
    </style>
    <![endif]-->
    <!--[if gt mso 15]>
    <style type="text/css" media="all">
        /* Outlook 2016 Height Fix */
        table, tr, td {border-collapse: collapse;}
        tr { font-size:0px; line-height:0px; border-collapse: collapse; }
    </style>
    <![endif]-->
    <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
        table {
            border-collapse: collapse;
            border-spacing: 0; }
    </style>
    <![endif]-->
    <!-- Progressive Enhancements : END -->

</head>
<!--
	The email background color (#222222) is defined in three places:
	1. body tag: for most email clients
	2. center tag: for Gmail and Inbox mobile apps and web versions of Gmail, GSuite, Inbox, Yahoo, AOL, Libero, Comcast, freenet, Mail.ru, Orange.fr
	3. mso conditional: For Windows 10 Mail
-->

<body width="100%"
    style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #ffffff;font-family: 'Montserrat', 'Verdana', sans-serif;">
    <center style="width: 100%; background-color: #ffffff;">
        <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff;">
        <tr>
            <td>
    <![endif]-->

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div
            style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">

        </div>
        <!-- Visually Hidden Preheader Text : END -->



        <!-- Email Body : BEGIN -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
            style="margin: auto;" class="email-container">
            <!-- Email Header : BEGIN -->
            <tr>
                <td style="padding: 20px 0; text-align: center">
                    <img src="{{config('app.url')}}/images/site-images/logo_color.png" width="159"
                        alt="alt_text" border="0"
                        style="height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                </td>
            </tr>

            <tr>
                <td style="padding: 20px 0; text-align: center">
                    <h1
                        style="margin: 0 0 10px; font-size: 32px; line-height: 30px; color: #9759FF; font-weight: normal;">
                        Time to 
Design Your Destiny</h1>
                </td>
            </tr>
            <!-- Email Header : END -->


            <!-- 1 Column Text + Button : BEGIN -->
            <tr>
                <td style="background-color: #ffffff;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td
                                style="padding: 20px;ont-family: 'Montserrat', 
                                'Verdana', sans-serif; font-size: 14px; line-height: 20px; color: #929394;text-align: center">
                                <h2
                                    style="text-align: center; margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #8EBEF8; font-weight: normal;font-family: 'Montserrat', 'Verdana', sans-serif;">
                                    Hi {{$user->name}},</h2>
                                <p style="margin: 0 0 10px;font-family: 'Montserrat', 'Verdana', sans-serif; text-align: center;">
                                        Ready to effortlessly share your spiritual gift with the world? Together, we’ll build your thriving online business.  </p>

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <!-- 1 Column Text + Button : END -->

           <!-- Thumbnail Left, Text Right : BEGIN -->
           <tr>
                <td dir="ltr" width="100%" style="padding: 10px; background-color: #EFF6FF;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        
                            <tr>

                                    <!-- Column : BEGIN -->
                                    <!-- background-image: url('{{config('app.url')}}/images/images/icons/email/hand.png')"    -->
                                    <td>
                    
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                            width="100%">
                                            <tr>
                                                    <td
                                                    style="padding: 20px;ont-family: 'Montserrat', 
                                                    'Verdana', sans-serif; font-size: 14px; line-height: 20px; color: #929394;text-align: center">
                                                  
                                                    <p style="color:#525252;margin: 0 0 10px;font-family: 'Montserrat', 'Verdana', sans-serif; text-align: center; padding: 10px 20px;">
                                                            Now that your account is ready, let’s prepare your profile for launch. Log in with your credentials for a step-by-step guide to completing your profile. 
                                                             </p>
                    
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <!-- Column : END -->
                    
                                </tr>


                        <tr>
                                    <!-- Column : BEGIN -->
                                    <!-- background-image: url('{{config('app.url')}}/images/images/icons/email/hand.png')"    -->
                                    <td>
                    
                                        <table style="margin-top: 10px !important;margin-bottom: 30px !important;"
                                            role="presentation" border="0" cellpadding="0" cellspacing="0"
                                            width="100%">
                                            <tr>
                                                <td dir="ltr" valign="top"
                                                    style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:white;      text-align: center; "
                                                    class="center-on-narrow">
                                                 <!--[if !gte mso 9]> -->
                                                 <a style="padding: 10px 20px;
                                                 background-color: #9daff9;
                                                 border-radius: 20px; color:white;"
                                                 href="{{config('app.url')}}/dashboard" target="blank">Log In Now</a>
                                                <!--[endif]-->
                                                <!--[if gte mso 9]>
                                                <table width="100%" style="background-color: #EFF6FF"><tr height="20"></tr></table>
                                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}/dashboard" style="height:38px;v-text-anchor:middle;width:125px;" arcsize="60%" opacity="0" stroke="f" fillcolor="#9daff9">
                                                <w:anchorlock/>
                                                <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">
                                                Log In Now                                              
                                                </center>
                                                </v:roundrect>
                                                <![endif]--> 
                                                </td>
                                            </tr>
                                        </table>
                                     </td>
                                    <!-- Column : END -->                    
                                 </tr>

                              


                                  

                    </table>

                </td>

            </tr>


            
            <tr>

                    <!-- Column : BEGIN -->
                    <!-- background-image: url('{{config('app.url')}}/images/images/icons/email/hand.png')"    -->
                    <td style=" background-size: cover;
                       
                        background-repeat: no-repeat;
                        position: relative;
                        background-position: center;
                         background-image: url('https://respectfully.com/images/icons/email/hand.png')">
    
                        <table style="
                                margin-bottom: 125px !important;" role="presentation" border="0" cellpadding="0"
                            cellspacing="0" width="100%">
                            <tr>
                                    <td
                                    style="padding: 20px;ont-family: 'Montserrat', 
                                    'Verdana', sans-serif; font-size: 14px; line-height: 20px; color: #929394;text-align: center">
                                    <h2
                                        style="text-align: center; margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #8EBEF8;font-family: 'Montserrat', 'Verdana', sans-serif;">
                                        Share Your Feedback</h2>
                                    <p style="margin: 0 0 10px;font-family: 'Montserrat', 'Verdana', sans-serif; text-align: center;">
                                            You have exclusive early access to our beta launch and we value your feedback. If anything looks or acts out of sorts, please 
                                            respond to this email with your comments.
                                            
                                             </p>
    
                                </td> 
                            </tr>
                        </table>
                    </td>
                    <!-- Column : END -->
    
                </tr>
           

            



                <tr>
                    <td dir="ltr" width="100%">
                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td>
                            <table style="margin-top: 50px !important;" role="presentation" border="0" cellpadding="0"
                              cellspacing="0" width="100%">
                              <tr>
                                <td dir="ltr" valign="top"
                                  style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#929394;; text-align: center; "
                                  class="center-on-narrow">
            
                                  <hr style="width:180px;margin-bottom: 30px;">
            
                                  <a href="https://www.instagram.com/respectfully/" target="blank" >
                                    <img src="{{config('app.url')}}/images/icons/email/instagram.png">
                                  </a>
                                  <a href="https://www.facebook.com/Respectfully/" target="blank" style="margin-left:14px;">
                                    <img src="{{config('app.url')}}/images/icons/email/facebook.png">
            
                                  </a>
                                  <a href="https://twitter.com/respectfully/" target="blank" style="margin-left:14px;">
                                    <img class="padding_social" src="{{config('app.url')}}/images/icons/email/twitter.png">
                                  </a>
                                  <a href="https://www.linkedin.com/company/respectfully/about/" target="blank" style="margin-left:14px;">
                                    <img src="{{config('app.url')}}/images/icons/email/linkedin.png">
                                  </a>
                                  
            
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td
                            style="font-family: 'Montserrat', 'Verdana', sans-serif;padding: 0px 20px; padding-top:15px; padding-bottom: 90px; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff!important;">
                            <span style="color: #929394;">Sent to {{$user->email}} because you joined our platform.
                            <br>
                            © Copyright 2020 VueMe.com, LLC</span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
        <!-- Email Body : END -->
        <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </center>
</body>

</html>