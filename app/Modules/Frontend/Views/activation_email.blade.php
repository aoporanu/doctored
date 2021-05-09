<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Doctered Email Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr bgcolor="#214214" style="border-radius: 10px;">
                        <td align="center"
                            style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">

                            <a class="navbar-brand" href="#"><img src="http://185.183.182.151/frontend/images/logo_web.svg"
                                    style="width:150px;float:left;padding-left: 40px;" class="img-responsive logo"></a>
                        </td>

                    </tr>
                    <!-- End of Header -->



                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <!-- <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>Lorem ipsum dolor sit amet!</b>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td align="left" style="padding: 40px 0px 30px 0px;">
                                        Dear {{$firstname}},
                                    </td>

                                </tr>
                                <tr>
                                    <td align="left" style="padding: 40px 0px 30px 0px;width:100%">
                                       You Account successfully created with Doctored Application.
									   
                                    </td>

                                </tr>
                            </table>
                            <table border="1" cellpadding="1" cellspacing="0" width="100%">
                              
                                <tr  style="height: 20px;">
                                    <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        USERID
                                    </td>
                                    <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Email
                                    </td>
									<td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Password
                                    </td>
                                   
                                </tr>
                                <tr  style="height: 20px;">
                                    <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        {{$patient_code}}
                                    </td>
                                    <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                           {{$email}}
                                    </td>
									 <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                           {{$password}}
                                    </td>
                                   
                                </tr>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="left" style="padding: 40px 0px 0px 0px;">
                                        Best Regards,
                                    </td>

                                </tr>
                                <tr>
                                    <td align="left" style="padding: 10px 0px 0px 0px;">
                                        Doctored Team
                                    </td>

                                </tr>

                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#214214" style="padding: 0px 30px 0px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center"
                                        style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">

                                        <a class="navbar-brand" href="#"><img src="http://185.183.182.151/frontend/images/foot_logo.svg"
                                                style="width:30px;float:left;padding-left:0px;"
                                                class="img-responsive logo"></a>
                                    </td>
                                    <td align="right" width="25%">
                                        <p style="color:#fff;font-size: 14px;">Copyright &copy;
                                            <span id="year">2020</span>
                                          </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>