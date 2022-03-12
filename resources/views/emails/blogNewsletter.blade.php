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
            font-family: 'Montserrat', 'Verdana', sans-serif;
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
                height: 40px;
                padding: 12px 0px;
            }

            .show-sm {
                display: inline !important;
            }

            .show-sm {
                display: inline-block !important;
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

        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="750"
            style="margin: auto; background: #43425D;" class="email-container">
            <tr>
                <td class="padding-sm" style="background:#43425D;text-align: center; color: #43425D;font-family: sans-serif; font-size: 15px;margin: auto; display: block;
                  background-size: cover; background-repeat: no-repeat; position: relative;">
                    <center><a href="{{config('app.url')}}">
                            <img src="{{config('app.url')}}/images/site-images/logo.png" width="159" />
                        </a></center>
                </td>
            </tr>
            <tr>
                <td
                    style="padding-top: 30px;background:#43425D;text-align: center; color: #FFFFFF;font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 15px; margin: auto; display: block;">

                    <div
                        style="text-transform: capitalize; margin:auto; text-align: center; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 18px; font-weight: 600;color:#FFFFFF; text-align: center;">
                        <div
                            style="font-family: 'Montserrat', 'Verdana', sans-serif; padding-left: 25px; padding-right: 25px; line-height: 1.5; max-width: 550px; margin: auto;">
                            Knowledge Is Freedom
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td
                    style="line-height: 24px; text-align: center; padding:30px 20px; margin: auto; font-family: 'Montserrat',  'Verdana', sans-serif; color: #FFFFFF;font-size: 16px;">
                    <div style="max-width: 550px; margin: auto; font-family: 'Montserrat',  'Verdana', sans-serif; ">
                        Personal freedom is a gift that we often take for granted in the Western world. This past year
                        has been an excellent example of just how illusory free will actually is, even in evolved
                        democracies. If there’s one huge takeaway from this pandemic, it’s that knowledge is freedom -
                        freedom from ignorance, freedom from fear of the unknown and freedom from complacency. The best
                        way we can prepare for a happy future is by arming ourselves with as much knowledge as possible.
                        Life is a never-ending lesson, and it’s time we started <br class="show-sm" />aiming for an A+.
                    </div>
                </td>
            </tr>
            <tr>

                <td
                    style="line-height: 24px; text-align: center; margin: auto; font-family: 'Montserrat',  'Verdana', sans-serif; color: #FFFFFF;font-size: 16px;">
                    <table cellspacing="0" width="100%" class="email-container"
                        style="max-width: 590px; background: #F0F0F7; line-height: 24px; text-align: center; margin: auto;  font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px; color: #FFFFFF;">
                        <tr>
                            <td
                                style="padding-top: 30px; color: #8EBEF8; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 16px;">
                                Top Story
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 20px; padding-right: 20px">
                                            <div class="hidden-sm"
                                                style="margin-top:10px; height: 200px; width: 100%; background-size: cover; background-repeat: no-repeat; background-image: url('{{config('app.url')}}/images/site-images/email_blog.png')">
                                            </div>
                                            <div class="show-sm"
                                                style="margin-top:10px; height: 200px; width: 100%; background-size: cover; background-repeat: no-repeat; background-image: url('{{config('app.url')}}/images/site-images/email_blog_mobile.png')">
                                            </div>
                                    </tr>
                                </table>
                            </td>
                        </tr>


                        <tr>
                            <td style="padding: 20px; color: #43425D;">
                                <a href="https://www.respectfully.com/blog/ruling-planet-what-means-for-you"
                                    style="color: #43425D; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 14px; max-width: 550px; margin: auto;">
                                    What’s Your Ruling Planet And What Does It Mean For You?
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding: 0px 20px; margin-top:10px; color: #656A71; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px;">
                                <div
                                    style="max-width: 550px; margin: auto;font-family: 'Montserrat',  'Verdana', sans-serif;">
                                    Tracking the planets’ orbits through the zodiac is at the heart of astrology. When you know your ruling planet, you can gain a better understanding of your own energy. Each of the planets in astrology have their own characteristics and they symbolize the different facets of our personality (for example, Mars illustrates how we can express anger or aggression)
                                    <a href="https://www.respectfully.com/blog/ruling-planet-what-means-for-you"
                                        style="color: #43425D; white-space: nowrap; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 12px;">…read
                                        more</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding: 0px 20px; color: #8EBEF8; padding-top:50px; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 16px;">
                                More From Our Blog
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 20px; padding-right: 20px">
                                            <div class="hidden-sm"
                                                style="margin-top:10px; height: 200px; width: 100%; background-size: cover; background-repeat: no-repeat; background-image: url('{{config('app.url')}}/images/site-images/email_blog2.png')">
                                            </div>
                                            <div class="show-sm"
                                                style="margin-top:10px; height: 200px; width: 100%; background-size: cover; background-repeat: no-repeat; background-image: url('{{config('app.url')}}/images/site-images/email_blog2_mobile.png')">
                                            </div>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px; color: #43425D;">
                                <a href="https://www.respectfully.com/blog/what-is-saturn-return"
                                    style="color: #43425D; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 14px; max-width: 550px; margin: auto;">
                                    What Is Your Saturn Return And What Do You Need To Know About It?
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding: 0px 20px; margin-top:10px; color: #656A71; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px;">
                                You may not have the expertise of an astrologist but you should definitely get clever on what a Saturn return is – especially if you’re in your late twenties
                                <a href="https://www.respectfully.com/blog/what-is-saturn-return"
                                    style="color: #43425D; white-space: nowrap; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 12px;">…read
                                    more</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 20px; padding-right: 20px">
                                            <div class="hidden-sm"
                                                style="margin-top:53px; height: 200px; width: 100%; background-size: cover; background-repeat: no-repeat; background-image: url('{{config('app.url')}}/images/site-images/email_blog3.png')">
                                            </div>
                                            <div class="show-sm"
                                                style="margin-top: 53px; height: 200px; width: 100%; background-size: cover; background-repeat: no-repeat; background-image: url('{{config('app.url')}}/images/site-images/email_blog3_mobile.png')">
                                            </div>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px; color: #43425D;">
                                <a href="https://www.respectfully.com/blog/things-to-do-during-full-moon"
                                    style="color: #43425D; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 14px; max-width: 550px; margin: auto;">
                                    7 Things You Should Be Doing During A Full Moon
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding: 0px 20px;padding-bottom: 20px; margin-top:10px; color: #656A71; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px;">
                                The full moon is a magical time. It can be a period of great renewal and creativity, which allows you to gain a clearer perspective of yourself and the world around you
                                <a href="https://www.respectfully.com/blog/things-to-do-during-full-moon"
                                    style="color: #43425D; white-space: nowrap; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 600; font-size: 12px;">…read
                                    more</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td
                    style="color: #8EBEF8; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 400; font-size: 16px;">
                    <table width="100%">
                        <tr>
                            <td
                                style="padding-top: 25px; line-height: 24px; text-align: center; margin: auto; font-family: 'Montserrat',  'Verdana', sans-serif; color: #FFFFFF;font-size: 16px;">
                                <div style="max-width: 550px; margin: auto">
                                    <table cellspacing="0" width="100%">
                                        <tr>
                                            <td
                                                style="margin-top: 25px; color: #8EBEF8; font-family: 'Montserrat',  'Verdana', sans-serif; font-weight: 400; font-size: 16px;text-align:center;">
                                                Thanks For Reading!</td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="margin-top:10px; padding-left: 20px; padding-right: 20px; color: #ffffff; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px;text-align:center;">
                                                We’ll see you next month with more psychic news; until then
                                                check out our
                                                blog for <a
                                                    style=" color: #8EBEF8; font-family: 'Montserrat',  'Verdana', sans-serif;"
                                                    href="https://www.respectfully.com/blog">more
                                                    stories</a>
                                                or visit our website to <a
                                                    style=" color: #8EBEF8; font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 16px;text-align:center;"
                                                    href="https://www.respectfully.com/">book in with one of
                                                    our
                                                    readers</a>.</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td dir="ltr" width="100%" style="background-color: #43425D;">
                                <div style="max-width: 550px; margin: auto">
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td>
                                                <table style="margin-top: 64px !important;" role="presentation"
                                                    border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                                                            class="center-on-narrow">

                                                            <hr style="width:180px;margin-bottom: 19px;">

                                                            <a href="https://www.instagram.com/respectfully/"
                                                                target="blank">
                                                                <img
                                                                    src="{{config('app.url')}}/images/icons/email/instagram_2.png">
                                                            </a>
                                                            <a href="https://www.facebook.com/Respectfully/"
                                                                target="blank" style="margin-left:14px;">
                                                                <img
                                                                    src="{{config('app.url')}}/images/icons/email/facebook_2.png">

                                                            </a>
                                                            <a href="https://twitter.com/respectfully/" target="blank"
                                                                style="margin-left:14px;">
                                                                <img class="padding_social"
                                                                    src="{{config('app.url')}}/images/icons/email/twitter_2.png">
                                                            </a>
                                                            <a href="https://www.linkedin.com/company/respectfully/about/"
                                                                target="blank" style="margin-left:14px;">
                                                                <img
                                                                    src="{{config('app.url')}}/images/icons/email/linkedin_2.png">
                                                            </a>


                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="font-family: 'Montserrat',  'Verdana', sans-serif; padding-top:15px; padding-bottom: 20px; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff!important;">
                                                <div style="font-family: 'Montserrat', 'Verdana', sans-serif;">
                                                    <a href="mailto:{{$user->email}}"> <span
                                                            style="color:#FFFFFF !important; font-family: 'Montserrat', 'Verdana', sans-serif; ">Sent
                                                            to <span
                                                                style="color:#8EBEF8; font-family: 'Montserrat', 'Verdana', sans-serif;">{!!
                                                                str_replace('.', '<span>.</span>',
                                                                str_replace('@', '<span>@</span>',
                                                                $user->email))
                                                                !!}</span></a> because you joined our
                                                    platform.
                                                    <br>
                                                    © Copyright 2021 <a target="_blank" href="VueMe.com"><span
                                                            style="color:#8EBEF8; font-family: 'Montserrat', 'Verdana', sans-serif;"><span
                                                                style="font-family: 'Montserrat', 'Verdana', sans-serif;">VueMe.</span>com</span></a>,
                                                    LLC</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>

</html>
</tr>
</table>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
</center>
</body>

</html>