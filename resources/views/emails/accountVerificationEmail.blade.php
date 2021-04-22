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
                <p><i>Your account verified for write news in <b style="color: rgb(238, 36, 10);">Instant News.</b></i></p>
                <p><i>Your Login Credential is</i></p>
                <p><i>Email :- {{ $email }}</i></p>
                <p><i>Password :- {{ $password }}</i></p>
                <p><i>Here is the login link :- </i></p>
                <a href="{{ url('/auther/auther-login') }}">Login</a>
                <br>
                <h5><i>Thankyou</i></h5>
                <h5><i>Instant News team</i></h5>
                <br>
                <br>
            </div>
        </div>
</body>
</html>