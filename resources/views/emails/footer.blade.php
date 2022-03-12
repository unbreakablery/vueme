
<tr>
    <td align="center" valign="top">
        <table width="600" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600px"
            border="0" bgcolor="#45519B" style="margin: auto">
            <tr>
                <td>
                    <table style="margin-top: 50px !important;" role="presentation" border="0" cellpadding="0"
                        cellspacing="0" width="100%">
                        <tr>
                            <td dir="ltr" valign="top"
                                style="font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 15px; color:#ffffff;      text-align: center; "
                                class="center-on-narrow">
                                <a href="https://www.instagram.com/respectfully/" target="blank">
                                    <img class="padding_social"
                                        src="{{config('app.url')}}/images/icons/email/instagram.png">
                                </a>
                                <a href="https://www.facebook.com/Respectfully/" target="blank">
                                    <img class="padding_social"
                                        src="{{config('app.url')}}/images/icons/email/facebook.png">

                                </a>
                                {{-- <a href="https://twitter.com/respectfully/" target="blank">
                                    <img class="padding_social"
                                        src="{{config('app.url')}}/images/icons/email/twitter.png">
                                </a> --}}
                                <a href="https://www.linkedin.com/company/respectfully/about/" target="blank">
                                    <img class="padding_social"
                                        src="{{config('app.url')}}/images/icons/email/linkedin.png">
                                </a>
                                <hr style="width:30%;margin-top: 20px;">

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td
                    style="font-family: 'Montserrat', 'Verdana', sans-serif;padding: 20px; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff!important;">
                    This email was sent to {{$user->email}} because you joined our platform.
                    <br><br>
                    © 2020 Respectfully™. Respectfully™ is a federally registered trademark.
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</center>
</body>

</html>