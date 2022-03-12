<?php

return [
    'templates' => [
        'blank_html' =>
            "
        <body style=\"color: rgb(118,130,147);
             background: #595f69 url('http://assets.collide.com/emails/img/bg-pattern.png');
             background-size: contain;
             background-position: center center;
             width: 100%;
             font-family: 'Montserrat', sans-serif;\">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat');

        /* General styling */
        body {
            color: rgb(118,130,147);
            background: #595f69 url('http://assets.collide.com/emails/img/bg-pattern.png');
            background-size: contain;
            background-position: center center;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
        }

        .row {
            background-color: #434a54;
            max-width: 610px;
            width: 100%;
            margin: auto;
            padding: 0 0 32px;
        }

        ul {
            padding: 0 30px;
            text-align: left;
            margin-left: 20px;
        }

        ul li {
            margin-bottom: 8px;
        }

        a {
            color: #aab2bd;
        }

        img {
            user-drag: none;
            user-select: none;
            -moz-user-select: none;
            -webkit-user-drag: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        .clearfix {
            clear: both;
        }

        .img-container {
            max-width: 500px;
            width: calc(100% - 16px);
            margin: auto;
            padding: 0 8px;
        }

        .img-container .col-2 {
            width: 49%;
            float: left;
        }

        .img-container .col-2:first-of-type {
            margin-right: 2%;
        }

        /* Header */
        .header td {
            padding: 24px 0 24px 30px;
        }

        .logo {
            width: 120px;
        }

        /* Body text */
        .promote-link {
            text-align: center;
        }

        table {
            width: 100%;
            background-color: #434a54;
        }

        .h1 td {
            padding: 0;
            text-align: center;
            color: rgb(26,255,204);
            border-top: 1px solid rgb(26,255,204);
            border-bottom: 1px solid rgb(26,255,204);
            text-transform: uppercase;
            font-size: 16px;
            padding: 10px 20px 10px 10px;
            font-weight: 100;
        }

        .h2 td {
            font-size: 36px;
            margin-top: 0;
            color: rgb(118,130,147);
            text-align: left;
            padding: 20px 30px 16px 30px;
            color: rgb(118,130,147);
        }

        .h3 td {
            text-align: left;
            padding: 0 30px;
            color: #aab2bd;
        }

        td {
            padding: 0 30px 16px 30px;
            font-size: 16px;
            line-height: 1.2;
            text-align: left;
            color: rgb(118,130,147);
        }

        /* Footer */
        .socials {
            padding: 0;
            text-align: center;
            margin: 0;
        }

        .socials li {
            list-style-type: none;
            display: inline-block;
        }

        .socials img {
            width: 32px;
        }

        .footer td {
            text-align: center;
            position: relative;
            padding: 8px 30px;
            font-size: 12px;
            color: rgb(118,130,147);
        }

        .footer.border-top td {
            border-top: 2px solid rgb(118,130,147);
            padding: 16px 30px 8px 30px;
        }

        .footer.border-bottom td {
            border-top: 1px solid rgb(118,130,147);
            border-bottom: 1px solid rgb(118,130,147);
            padding: 4px 0;
        }
    </style>
    <style type=\"text/css\">
        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
        img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
        table{border-collapse: collapse !important;}
        body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}
    </style>
    <!--[if gte mso 12]>
    <style type=\"text/css\">
        .mso-right {
            padding-left: 20px;
        }
    </style>
    <![endif]-->
    <!--[if gt mso 15]>
    <style type=\"text/css\" media=\"all\">
        /* Outlook 2016 Height Fix */
        table, tr, td {border-collapse: collapse;}
        tr { font-size:0px; line-height:0px; border-collapse: collapse; }
    </style>
    <![endif]-->
    <!--[if (gte mso 9)|(IE)]>
    <style type=\"text/css\">
    table {
    border-collapse: collapse;
    border-spacing: 0; }
    </style>
    <![endif]-->

    <div class=\"row\" style=\"background-color: #434a54;
                            max-width: 610px;
                            width: 100%;
                            margin: auto;
                            padding: 0 0 32px;\">
        <!-- START OF HEADER TEMPLATE-->
        <table width=\"100%\" style=\"background-color: #434a54;\">
            <tr class=\"header\">
                <td style=\"padding: 24px 0 24px 30px;\"><a style=\"color: #aab2bd;\" href=\"https://www.collide.com/\"><img class=\"logo\" src=\"http://assets.collide.com/emails/img/logo.png\" alt=\"Collide\"></a></td>
            </tr>
            <!-- END OF HEADER TEMPLATE -->

            <:body>

            <!-- START OF FOOTER TEMPLATE-->
            <tr class=\"footer border-top\">
                <td style=\"padding: 16px 30px 8px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);
                        border-top: 2px solid rgb(118,130,147);\">
                    <a style=\"color: #aab2bd;\" href=\"https://collide.zendesk.com/hc/en-us/sections/360003127931-Success-Hacks\">Click here</a> for more tips, tricks, and advice.
                </td>
            </tr>
            <tr class=\"footer\">
                <td style=\"padding: 0 30px 16px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);\">This email was sent to <span style=\"color: rgb(118,130,147);\"><:email></span> because you joined our platform as a Creator. Love Collide? To ensure you get all our correspondence be sure to add Collide to your address book or safe senders list.</td>
            </tr>
            <tr class=\"footer\">
                <td style=\"padding: 0 30px 16px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);\">© 2019 Collide. Collide is a federally registered trademark.</td>
            </tr>
            <tr class=\"footer\">
                <td style=\"padding: 0 30px 16px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);\">
                    <table style=\"text-align: center; margin: auto; width: 200px;\">
                        <tr>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.instagram.com/collidehq/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-instagram.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.linkedin.com/company/collide-llc/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-linkedin.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.facebook.com/CollideHQ/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-facebook32.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://twitter.com/CollideHQ/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-twitter32.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.collide.com/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-collide.png\" alt=\"\"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class=\"footer border-bottom\">
                <td style=\"border-top: 1px solid rgb(118,130,147);
                        border-bottom: 1px solid rgb(118,130,147);
                        padding: 4px 0;\">

                </td>
            </tr>
        </table>
    </div>
</body>
        ",


        'user_notify_online' =>
            "
        <!DOCTYPE html>
<html>
  <head>
    <title>Collide</title>

    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
    <style type=\"text/css\">
      /* CLIENT-SPECIFIC STYLES */
      body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
      table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
      img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

      /* RESET STYLES */
      img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
      table{border-collapse: collapse !important;}
      body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

      /* iOS BLUE LINKS */
      a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
      }
      .main-padding{
      padding:40px 20px;
      }
      .btn{
      transition: all .2s ease-in-out;
      }
      .btn:hover{
      background:#1a68c3;
      }

      /* MOBILE STYLES */
      @media screen and (max-width: 525px) {

      /* ALLOWS FOR FLUID TABLES */
      .wrapper {
      width: 100% !important;
      max-width: 100% !important;
      }
      .main-padding{
      padding:10px;
      }

      /* ADJUSTS LAYOUT OF LOGO IMAGE */
      .logo img {
      margin: 0 auto !important;
      }

      /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
      .mobile-hide {
      display: none !important;
      }

      .img-max {
      max-width: 100% !important;
      width: 100% !important;
      height: auto !important;
      }

      /* FULL-WIDTH TABLES */
      .responsive-table {
      width: 100% !important;
      }

      /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
      .padding {
      padding: 30px 5% 15px 5% !important;
      }

      .padding-meta {
      padding: 30px 5% 0px 5% !important;
      text-align: center;
      }


      .no-padding {
      padding: 0 !important;
      }
      
      .padding-twenty{
      padding-bottom:20px !important;
      }


      /* ADJUST BUTTONS ON MOBILE */
      .mobile-button-container {
      margin: 0 auto;
      width: 100% !important;
      }

      .mobile-button {
      padding: 15px !important;
      border: 0 !important;
      font-size: 16px !important;
      display: block !important;
      }

      }

      /* ANDROID CENTER FIX */
      div[style*=\"margin: 16px 0;\"] { margin: 0 !important; }
    </style>
    <!--[if gte mso 12]>
	<style type=\"text/css\">
	  .mso-right {
	  padding-left: 20px;
	  }
	</style>
	<![endif]-->
  </head>
  <body bgcolor=\"#e4e6ed\" style=\"margin: 0 !important; padding: 0 !important;\">

    <!-- HEADER -->
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
      <tr>
        <td bgcolor=\"#f6f7fb\" align=\"center\">
          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"max-width: 570px;\" class=\"wrapper\" bgcolor=\"#f6f7fb\">
            <tr>
              <td align=\"center\" valign=\"top\" style=\"padding: 15px 0;\" class=\"logo\">
                <a href=\"<?=link_track(\"[--URL--]\")?>\" target=\"_blank\"><img src=\"https://assets.collide.com/images/v1/email/logo.png\" style=\"width:162px;\" width=\"162\"></a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=\"center\" style=\"padding:20px 15px 25px 15px;background-color:#e4e6ed\">
          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" class=\"responsive-table\">
	    <tr>
              <td>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">
                  <tr>
                    <td style=\"padding:0;margin:0;border-radius:3px\" bgcolor=\"#ffffff\">
                      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">
	                <tr>
			  <td align=\"center\" style=\"background-color:#fff;background-image:url('https://assets.collide.com/images/v1/email/bg-gradient.jpg');background-repeat:no-repeat;width:600px;height:300px;background-size:100%;vertical-align: bottom\"><img src=\"<:profile_image>\" width=\"250\" height=\"250\" style=\"padding-top:60px;\">
			  </td>
			</tr>
	                <tr>
                          <td align=\"center\" style=\"font-family:MarkOT-Bold, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:30px;line-height:40px;font-weight:300;color:#2c3f51;padding:30px 40px\" class=\"padding-copy\">
	                    <:profile_name> is <span style=\"color:#217ce6\">live</span> now
                          </td>
                        </tr>
	                <tr>
                          <td align=\"center\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px;line-height:24px;font-weight:300;color:#2c3f51;padding:0px 40px\" class=\"padding-copy\">
	                    Ready to watch one of your favorites in real-time? Click below to see what's only happening on Collide!
                          </td>
                        </tr>
                        <tr>
			  <td align=\"center\" style=\"padding: 0px 15px 0px 15px;\" class=\"section-padding\">
			    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" class=\"responsive-table\" bgcolor=\"#ffffff\">
			      <tr>
				<td style=\"padding-bottom:40px;\" class=\"padding-twenty\">
				  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				    <tr>
				      <td align=\"center\">
					<!-- BULLETPROOF BUTTON -->
					<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					  <tr>
					    <td align=\"center\" style=\"padding-top: 20px;\" class=\"padding\">
					      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"mobile-button-container\">
						<tr>
						  <td align=\"center\" style=\"border-radius: 3px;\" bgcolor=\"#217ce6\"><a href=\"<?=link_track(\"[--PROFILE_CHAT_LINK--]\")?>\" target=\"_blank\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:14px;line-height:24px;font-weight:300;color: #ffffff; text-decoration: none; border-radius: 3px; padding: 10px 25px; border: 1px solid #217ce6; display: inline-block;\" class=\"mobile-button btn\">Watch Now</a></td>
						</tr>
					      </table>
					    </td>
					  </tr>
					</table>
				      </td>
				    </tr>
				  </table>
				</td>
			      </tr>
			    </table>
			  </td>
			</tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=\"center\" style=\"padding:0;\" bgcolor=\"#e4e6ed\">
	  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" class=\"responsive-table\">
	    <tr>
	      <td align=\"center\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px;line-height:18px;font-weight:300;color:#323434;padding:0 20px 15px 20px;\" class=\"padding-copy\">
	        This email was sent to <:email>. <a href=\"<?=unsubscribe()?>\">UNSUBSCRIBE</a> to no longer receive our messages or change your email preferences.
	      </td>
	    </tr>
	  </table>
	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"responsive-table\" bgcolor=\"#e4e6ed\">
	    <tr>
	      <td width=\"46%\" bgcolor=\"#e4e6ed\"></td>
	      <td width=\"8%\" bgcolor=\"#e4e6ed\">
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"responsive-table socials\">
		  <tr>
		    <td align=\"center\" style=\"padding:0 5px;\"><a href=\"https://www.facebook.com/thisiscollide\" align=\"center\"><img src=\"https://assets.collide.com/images/v1/email/icon-fb.png\" width=\"25\"></a></td>
		    <td align=\"center\" style=\"padding:0 5px;\"><a href=\"https://twitter.com/collide\"><img src=\"https://assets.collide.com/images/v1/email/icon-tw.png\" width=\"25\"></a></td>
		    <td align=\"center\" style=\"padding:0 5px;\"><a href=\"https://www.instagram.com/thisiscollide/\"><img src=\"https://assets.collide.com/images/v1/email/icon-ig.png\" width=\"25\"></a></td>
		  </tr>
		</table>
	      </td>
	      <td width=\"46%\" bgcolor=\"#e4e6ed\"></td>
	    </tr>
	  </table>
	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"max-width: 570px;\" class=\"responsive-table\">
	    <tr>
	      <td style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:10px;line-height:15px;font-weight:300;color:#2c3f51;text-align: center;padding:10px 0 10px 0\" align=\"center\" width=\"60%\" bgcolor=\"#e4e6ed\">
		© 2017 Collide | All rights reserved
	      </td>
	    </tr>
	  </table>
	</td>
      </tr>
    </table>
  </body>
</html>
        ",


        'password_reset_link' =>
            "
<body style=\"color: rgb(118,130,147);
             background: #595f69 url('http://assets.collide.com/emails/img/bg-pattern.png');
             background-size: contain;
             background-position: center center;
             width: 100%;
             font-family: 'Montserrat', sans-serif;\">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat');

        /* General styling */
        body {
            color: rgb(118,130,147);
            background: #595f69 url('http://assets.collide.com/emails/img/bg-pattern.png');
            background-size: contain;
            background-position: center center;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
        }

        .row {
            background-color: #434a54;
            max-width: 610px;
            width: 100%;
            margin: auto;
            padding: 0 0 32px;
        }

        ul {
            padding: 0 30px;
            text-align: left;
            margin-left: 20px;
        }

        ul li {
            margin-bottom: 8px;
        }

        a {
            color: #aab2bd;
        }

        img {
            user-drag: none;
            user-select: none;
            -moz-user-select: none;
            -webkit-user-drag: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        .clearfix {
            clear: both;
        }

        .img-container {
            max-width: 500px;
            width: calc(100% - 16px);
            margin: auto;
            padding: 0 8px;
        }

        .img-container .col-2 {
            width: 49%;
            float: left;
        }

        .img-container .col-2:first-of-type {
            margin-right: 2%;
        }

        /* Header */
        .header td {
            padding: 24px 0 24px 30px;
        }

        .logo {
            width: 120px;
        }

        /* Body text */
        .promote-link {
            text-align: center;
        }

        table {
            width: 100%;
            background-color: #434a54;
        }

        .h1 td {
            padding: 0;
            text-align: center;
            color: rgb(26,255,204);
            border-top: 1px solid rgb(26,255,204);
            border-bottom: 1px solid rgb(26,255,204);
            text-transform: uppercase;
            font-size: 16px;
            padding: 10px 20px 10px 10px;
            font-weight: 100;
        }

        .h2 td {
            font-size: 36px;
            margin-top: 0;
            color: rgb(118,130,147);
            text-align: left;
            padding: 20px 30px 16px 30px;
            color: rgb(118,130,147);
        }

        .h3 td {
            text-align: left;
            padding: 0 30px;
            color: #aab2bd;
        }

        td {
            padding: 0 30px 16px 30px;
            font-size: 16px;
            line-height: 1.2;
            text-align: left;
            color: rgb(118,130,147);
        }

        /* Footer */
        .socials {
            padding: 0;
            text-align: center;
            margin: 0;
        }

        .socials li {
            list-style-type: none;
            display: inline-block;
        }

        .socials img {
            width: 32px;
        }

        .footer td {
            text-align: center;
            position: relative;
            padding: 8px 30px;
            font-size: 12px;
            color: rgb(118,130,147);
        }

        .footer.border-top td {
            border-top: 2px solid rgb(118,130,147);
            padding: 16px 30px 8px 30px;
        }

        .footer.border-bottom td {
            border-top: 1px solid rgb(118,130,147);
            border-bottom: 1px solid rgb(118,130,147);
            padding: 4px 0;
        }
    </style>
    <style type=\"text/css\">
        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
        img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
        table{border-collapse: collapse !important;}
        body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}
    </style>
    <!--[if gte mso 12]>
    <style type=\"text/css\">
        .mso-right {
            padding-left: 20px;
        }
    </style>
    <![endif]-->
    <!--[if gt mso 15]>
    <style type=\"text/css\" media=\"all\">
        /* Outlook 2016 Height Fix */
        table, tr, td {border-collapse: collapse;}
        tr { font-size:0px; line-height:0px; border-collapse: collapse; }
    </style>
    <![endif]-->
    <!--[if (gte mso 9)|(IE)]>
    <style type=\"text/css\">
    table {
    border-collapse: collapse;
    border-spacing: 0; }
    </style>
    <![endif]-->

    <div class=\"row\" style=\"background-color: #434a54;
                            max-width: 610px;
                            width: 100%;
                            margin: auto;
                            padding: 0 0 32px;\">
        <!-- START OF HEADER TEMPLATE-->
        <table width=\"100%\" style=\"background-color: #434a54;\">
            <tr class=\"header\">
                <td style=\"padding: 24px 0 24px 30px;\"><a style=\"color: #aab2bd;\" href=\"https://www.collide.com/\"><img class=\"logo\" src=\"http://assets.collide.com/emails/img/logo.png\" alt=\"Collide\"></a></td>
            </tr>
            <!-- END OF HEADER TEMPLATE -->

            <:body>

            <!-- START OF FOOTER TEMPLATE-->


            <tr class=\"footer border-top\">
                <td style=\"padding: 16px 30px 8px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);
                        border-top: 2px solid rgb(118,130,147);\">
                </td>
            </tr>

            <tr class=\"footer\">
                <td style=\"padding: 0 30px 16px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);\">© 2019 Collide. Collide is a federally registered trademark.</td>
            </tr>
            <tr class=\"footer\">
                <td style=\"padding: 0 30px 16px 30px;
                       font-size: 12px;
                       line-height: 1.2;
                       text-align: center;
                       color: rgb(118,130,147);\">
                    <table style=\"text-align: center; margin: auto; width: 200px;\">
                        <tr>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.instagram.com/collidehq/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-instagram.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.linkedin.com/company/collide-llc/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-linkedin.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.facebook.com/CollideHQ/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-facebook32.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://twitter.com/CollideHQ/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-twitter32.png\" alt=\"\"></a></td>
                            <td style=\"padding: 0 4px 16px 4px;\"><a href=\"https://www.collide.com/\"><img style=\"width: 32px;\" src=\"http://assets.collide.com/emails/img/icon-collide.png\" alt=\"\"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class=\"footer border-bottom\">
                <td style=\"border-top: 1px solid rgb(118,130,147);
                        border-bottom: 1px solid rgb(118,130,147);
                        padding: 4px 0;\">

                </td>
            </tr>
        </table>
    </div>
</body>
",

        'register_success' =>
            "
        <!DOCTYPE html>
<html>
  <head>
    <title>Collide</title>

    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
    <style type=\"text/css\">
      /* CLIENT-SPECIFIC STYLES */
      body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
      table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
      img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

      /* RESET STYLES */
      img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
      table{border-collapse: collapse !important;}
      body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

      /* iOS BLUE LINKS */
      a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
      }
      .main-padding{
      padding:40px 20px;
      }
      .btn{
      transition: all .2s ease-in-out;
      }
      .btn:hover{
      background:#1a68c3;
      }

      /* MOBILE STYLES */
      @media screen and (max-width: 525px) {

      /* ALLOWS FOR FLUID TABLES */
      .wrapper {
      width: 100% !important;
      max-width: 100% !important;
      }
      .main-padding{
      padding:10px;
      }

      /* ADJUSTS LAYOUT OF LOGO IMAGE */
      .logo img {
      margin: 0 auto !important;
      }

      /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
      .mobile-hide {
      display: none !important;
      }

      .img-max {
      max-width: 100% !important;
      width: 100% !important;
      height: auto !important;
      }

      /* FULL-WIDTH TABLES */
      .responsive-table {
      width: 100% !important;
      }

      /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
      .padding {
      padding: 30px 5% 15px 5% !important;
      }

      .padding-meta {
      padding: 30px 5% 0px 5% !important;
      text-align: center;
      }


      .no-padding {
      padding: 0 !important;
      }
      
      .padding-twenty{
      padding-bottom:20px !important;
      }


      /* ADJUST BUTTONS ON MOBILE */
      .mobile-button-container {
      margin: 0 auto;
      width: 100% !important;
      }

      .mobile-button {
      padding: 15px !important;
      border: 0 !important;
      font-size: 16px !important;
      display: block !important;
      }

      }

      /* ANDROID CENTER FIX */
      div[style*=\"margin: 16px 0;\"] { margin: 0 !important; }
    </style>
    <!--[if gte mso 12]>
	<style type=\"text/css\">
	  .mso-right {
	  padding-left: 20px;
	  }
	</style>
	<![endif]-->
  </head>
  <body bgcolor=\"#e4e6ed\" style=\"margin: 0 !important; padding: 0 !important;\">
    <!-- HEADER -->
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
      <tr>
        <td bgcolor=\"#f6f7fb\" align=\"center\">
          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" style=\"max-width: 570px;\" class=\"wrapper\" bgcolor=\"#f6f7fb\">
            <tr>
              <td align=\"center\" valign=\"top\" style=\"padding: 15px 0;\" class=\"logo\">
                <a href=\"<?=link_track(\"[--URL--]\")?>\" target=\"_blank\"><img src=\"https://assets.collide.com/images/v1/email/logo.png\" style=\"width:162px;\" width=\"162\"></a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=\"center\" style=\"padding:20px 15px 25px 15px;background-color:#e4e6ed\">
          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" class=\"responsive-table\">
	    <tr>
              <td>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">
                  <tr>
                    <td style=\"padding:0;margin:0;border-radius:3px\" bgcolor=\"#ffffff\">
                      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">
	                <tr>
			  <td><a href=\"<?=link_track(\"[--URL--]\")?>\" target=\"_blank\"><img src=\"https://assets.collide.com/images/v1/email/bar-gradient.png\" class=\"img-max\" id=\"banner\" width=\"600\" height=\"30\"></a>
			  </td>
			</tr>
	                <tr>
                          <td align=\"center\" style=\"font-family:MarkOT-Bold, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:30px;line-height:40px;font-weight:300;color:#2c3f51;padding:30px 40px\" class=\"padding-copy\">
	                    Activate your Collide Account
                          </td>
                        </tr>
	                <tr>
                          <td align=\"center\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px;line-height:24px;font-weight:300;color:#2c3f51;padding:0 40px\" class=\"padding-copy\">
	                    Your Collide account has been successfully created. Click the button below to activate your account.
                          </td>
                        </tr>
                        <tr>
			  <td align=\"center\" style=\"padding: 0px 15px 0px 15px;\" class=\"section-padding\">
			    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" class=\"responsive-table\" bgcolor=\"#ffffff\">
			      <tr>
				<td style=\"padding-bottom:40px;\" class=\"padding-twenty\">
				  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				    <tr>
				      <td align=\"center\">
					<!-- BULLETPROOF BUTTON -->
					<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					  <tr>
					    <td align=\"center\" style=\"padding-top: 20px;\" class=\"padding\">
					      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"mobile-button-container\">
						<tr>
						  <td align=\"center\" style=\"border-radius: 3px;\" bgcolor=\"#217ce6\"><a href=\"<?=link_track(\"[--VALIDATION_LINK--]\")?>\" target=\"_blank\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:14px;line-height:24px;font-weight:300;color: #ffffff; text-decoration: none; border-radius: 3px; padding: 10px 25px; border: 1px solid #217ce6; display: inline-block;\" class=\"mobile-button btn\">Activate Account</a></td>
						</tr>
					      </table>
					    </td>
					  </tr>
					</table>
				      </td>
				    </tr>
				  </table>
				</td>
			      </tr>
			    </table>
			  </td>
			</tr>
			<tr>
                          <td align=\"center\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px;line-height:24px;font-weight:300;color:#2c3f51;padding:0px 40px\" class=\"padding-copy\">
	                    <hr style=\"margin:0;padding:0;\">
                          </td>
                        </tr>
                        <tr>
                          <td align=\"center\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px;line-height:18px;font-weight:300;color:#777777;padding:25px 40px\" class=\"padding-copy\">
	                    If you received this email in error or did not sign up for a Collide account, you can simply ignore this email -- No account will be activated and no future emails will be sent to you.
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=\"center\" style=\"padding:0;\" bgcolor=\"#e4e6ed\">
	  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"570\" class=\"responsive-table\">
	    <tr>
	      <td align=\"center\" style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px;line-height:18px;font-weight:300;color:#323434;padding:0 20px 15px 20px;\" class=\"padding-copy\">
	        This email was sent to <:email>. <a href=\"<?=unsubscribe()?>\">UNSUBSCRIBE</a> to no longer receive our messages or change your email preferences.
	      </td>
	    </tr>
	  </table>
	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"responsive-table\" bgcolor=\"#e4e6ed\">
	    <tr>
	      <td width=\"46%\" bgcolor=\"#e4e6ed\"></td>
	      <td width=\"8%\" bgcolor=\"#e4e6ed\">
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"responsive-table socials\">
		  <tr>
		    <td align=\"center\" style=\"padding:0 5px;\"><a href=\"https://www.facebook.com/thisiscollide\" align=\"center\"><img src=\"https://assets.collide.com/images/v1/email/icon-fb.png\" width=\"25\"></a></td>
		    <td align=\"center\" style=\"padding:0 5px;\"><a href=\"https://twitter.com/collide\"><img src=\"https://assets.collide.com/images/v1/email/icon-tw.png\" width=\"25\"></a></td>
		    <td align=\"center\" style=\"padding:0 5px;\"><a href=\"https://www.instagram.com/thisiscollide/\"><img src=\"https://assets.collide.com/images/v1/email/icon-ig.png\" width=\"25\"></a></td>
		  </tr>
		</table>
	      </td>
	      <td width=\"46%\" bgcolor=\"#e4e6ed\"></td>
	    </tr>
	  </table>
	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"max-width: 570px;\" class=\"responsive-table\">			         
	    <tr>
	      <td style=\"font-family:MarkOT-Light, Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:10px;line-height:15px;font-weight:300;color:#2c3f51;text-align: center;padding:10px 0 10px 0\" align=\"center\" width=\"60%\" bgcolor=\"#e4e6ed\">
		© 2017 Collide | All rights reserved
	      </td>
	    </tr>
	  </table>
	</td>
      </tr>
    </table>
  </body>
</html>
        "
    ]
];
