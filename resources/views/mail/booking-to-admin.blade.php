
<html>
 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>A Simple Responsive HTML Email</title>
    <style type="text/css">
    body {margin: 0; padding: 0; min-width: 100%!important;}
    img {height: auto;}
    .content {width: 100%; max-width: 700px;}
    .header {padding: 20px 30px;}
    .innerpadding {padding: 30px 30px 30px 30px;}
    .borderbottom {border-bottom: 1px solid #f2eeed;}
    .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
    .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
    .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
    .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
    .h4 {    font-size: 20px; }
    .bodycopy {font-size: 16px; line-height: 22px;}
    .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
    .button a {color: #ffffff; text-decoration: none;}
    .footer {padding: 20px 30px 15px 30px;}
    .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
    .footercopy a {color: #ffffff; text-decoration: underline;}
  
    @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
    body[yahoo] .hide {display: none!important;}
    body[yahoo] .buttonwrapper {background-color: transparent!important;}
    body[yahoo] .button {padding: 0px!important;}
    body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
    body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
    }
  
    /*@media only screen and (min-device-width: 601px) {
      .content {width: 600px !important;}
      .col380 {width: 380px!important;}
      }*/
  
    </style>
  </head>
  
  <body yahoo bgcolor="#f6f8f1">
  <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td> 
      <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td bgcolor="#c7d8a7" class="header">
            <table class="col" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
              <tr>
                <td height="70">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" class="h1" style="padding: 5px 0 0 0;">
                        <img src="{{ $logo }}" alt="Logo-img" width="100"/>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" class="h1" style="padding: 20px 0 0 0;">
                        New Booking for {{ $name }} !
                      </td>
                    </tr>
                 
                  </table>
                </td>
              </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
                  </td>
                </tr>
            </table>
            <![endif]-->
          </td>
        </tr>
        <tr>
          <td class="innerpadding borderbottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="h2" style="text-align: center;">
                  Booking Details<hr>
                </td>
              </tr>
  
              <tr>
                <td class="bodycopy">
                  <table width="100%">
                      <tr>
                          <td>
                              <b>Name: </b>{{ $name }}
                          </td>
                          <td>
                              <b>Email: </b>{{ $email }}
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <b>Phone: </b>+977{{ $phone }}
                          </td>
                          <td>
                              <b>Address: </b>{{ $address }}
                          </td>
                      </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table>
              <hr>
              <tr>
                  <td class="shipping-details">
                      <div>
                          <b>Hostel's Name: </b>{{ $hostel_name }}
                      </div>
                      <div>
                          <b>Type: </b>{{ $type }}
                      </div>
                      <div>
                          <b>Length of Stay: </b>{{ $length_of_stay }}
                      </div>
                      <div>
                          <b>Room Type: </b>{{ $room_type }}
                      </div>
                      <div>
                          <b>No of People: </b>{{ $no_of_people }}
                      </div>
                      <div>
                          <b>City: </b>{{ $city }}
                      </div>
                      <div>
                          <b>Place: </b>{{ $place }}
                      </div>
                  </td>
              </tr>
            </table>
          </td>
        </tr>
          
        <tr>
          <td class="footer" bgcolor="#f6f8f1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" class="footercopy">
                  © 2019 EZE Hostels. All Rights Reserved.             
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
  