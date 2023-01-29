<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style>
    .wrapper {
        border-spacing:0 8px !important;
    }
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }
        .footer {
            width: 100% !important;
        }
    }
    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">

                        {{-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="p30-15" style="padding: 50px 0px 40px 0px;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <th class="column-top" width="145" style="font-size:0pt; text-align: center; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
                                                <table width="100%" border="0"  cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="img m-center" align="center"  style="text-align: center !important; font-size:0pt; line-height:0pt;">
                                                            <a href="https://event.onar.asia">
                                                                <img src="https://event.onar.asia/assets/frontend/img/hero-carousel/hero-carousel-3.svg" style="align-self: center" width="300" height="100" editable="true" border="0" alt="" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </th>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table> --}}


            <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    {{ Illuminate\Mail\Markdown::parse($slot) }}

                                    {{ $subcopy ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                {{-- <tr style="">
                    <td class="body" width="100%" cellpadding="0"  cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="p30-15" style="padding: 50px 30px;" bgcolor="#ffffff">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" style="padding-bottom: 30px;">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.facebook.com/fintagid" target="_blank"><img src="https://fintag.id/img/mail/t8_ico_facebook.jpg" width="38" height="38" editable="true" border="0" alt="" /></a></td>
                                                        <td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.instagram.com/fintagid/" target="_blank"><img src="https://fintag.id/img/mail/t8_ico_instagram.jpg" width="38" height="38" editable="true" border="0" alt="" /></a></td>
                                                        <td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://twitter.com/fintagid"  target="_blank"><img src="https://fintag.id/img/mail/t8_ico_twitter.jpg" width="38" height="38" editable="true" border="0" alt="" /></a></td>
                                                        <td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.linkedin.com/company/fintag/" target="_blank"><img src="https://fintag.id/img/mail/t8_ico_linkedin.jpg" width="38" height="38" editable="true" border="0" alt="" /></a></td>
                                                        <td class="img" width="38" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.youtube.com/channel/UCeSUDgNX6zkDrSUPfFM5pwg" target="_blank"><img src="https://fintag.id/img/mail/youtube.jpg" width="38" height="38" editable="true" border="0" alt="" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-footer1 pb10" style="color:#999999; font-family:'Roboto', Arial,sans-serif; font-size:16px; line-height:20px; text-align:center; padding-bottom:10px;"><multiline>Fintag - Empower Businesses</multiline></td>
                                        </tr>
                                        <tr>
                                            <td class="text-footer2 pb30" style="color:#999999; font-family:'Roboto', Arial,sans-serif; font-size:12px; line-height:26px; text-align:center; padding-bottom:30px;"><multiline>Gedung Tifa, Lantai 7, Jalan Kuningan Barat 1 No.26, Kelurahan Kuningan Barat,
                                                    Kecamatan Mampang Prapatan, Jakarta Selatan</multiline></td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr> --}}

            </table>
        </td>
    </tr>
</table>
</body>
</html>
