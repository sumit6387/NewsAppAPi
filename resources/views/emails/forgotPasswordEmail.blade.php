<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        
    </style>
</head>
<body>
    <center>
        <h1 style="margin-top: 30px;"><i>Instant News</i></h1></center>
        <div class="container" style="background-color:#F3ECEC; font-size:20px;margin-bottom:10%;" >
            <br>
            <div style="margin-left:5%;margin-right:5%;"> 
                <p style="margin-top: 10px;"><i>Hello <b>{{$name}}</b></i></p>
                <p><i>You forgot the password on <b style="color: rgb(238, 10, 10);">Instant News.</b></i></p>
                <p><i>Now Reset Your password here</i></p>
                <a href="{{ url('/auther/forgetPasswordProcess/'.$email) }}">Change Password</a>
                <br>
                <h5><i>Thankyou</i></h5>
                <h5><i>Instant News team</i></h5>
            </div>
        </div>
</body>
</html>