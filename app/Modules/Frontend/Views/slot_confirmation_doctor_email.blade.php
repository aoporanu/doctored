<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Appointment Booking Successful</title>
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
                                        <td align="left" style="padding: 10px 0px 10px 0px;">
                                            Dear {{ucfirst($doctorName)}},
                                        </td>

                                    </tr>
                                    <tr>
                                        <td align="left" style="padding: 40px 0px 30px 0px;width:100%">
                                            You have an appointment with {{ucfirst($patientName)}} below are the details.
                                        </td>
                                    </tr>
                                </table>     
                                <table border="1" cellpadding="1" cellspacing="0" width="100%">
								 
								<tr><td style="font-weight:bold"> Patient Name</td><td>{{ucfirst($patientName)}}</td></tr>
								<tr><td style="font-weight:bold">Booking ID </td><td>{{$data['booking_id']}} </td></tr>
									<tr><td style="font-weight:bold">Hospital </td><td>{{ucfirst($hospitalName)}} </td></tr>
							<tr><td style="font-weight:bold">Date</td><td>{{$data['booking_date']}} </td></tr>
							<tr><td style="font-weight:bold">Time</td><td>{{$data['booking_start_time']}} ({{$data['booking_time_long']}})</td></tr>
								<tr><td style="font-weight:bold">Type</td><td>{{ucfirst($type)}}</td></tr>
							<tr><td style="font-weight:bold">Title</td><td>{{ucfirst($data['title'])}}</td></tr>
							<tr><td style="font-weight:bold">Description</td><td>{{ucfirst($data['description'])}}</td></tr>
							
							<tr><td style="font-weight:bold">Email</td><td>{{$data['email']}}</td></tr>
							<tr><td style="font-weight:bold">Contact No</td><td>{{$data['phone']}}</td></tr>		
							 <tr><td style="font-weight:bold">Contact No</td><td>{{$data['phone']}}</td></tr>	
					<tr><td style="font-weight:bold">Created</td><td>{{$data['created_at']}}</td></tr>							 
					<tr><td style="font-weight:bold">Status </td><td>{{ucfirst($data['booking_status'])}}</td></tr>							 
					
							 
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