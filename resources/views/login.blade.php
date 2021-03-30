<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Matka App ">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>Admin Login - Instant News</title>
  <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{url('css/bootstrap-theme.css')}}" rel="stylesheet">
  <link href="{{url('css/elegant-icons-style.css')}}" rel="stylesheet" />
  <link href="{{url('css/font-awesome.css')}}" rel="stylesheet" />
  <link href="{{url('css/style.css')}}" rel="stylesheet">
  <link href="{{url('css/style-responsive.css')}}" rel="stylesheet" />
</head>

<body class="login-img3-body">

  <div class="container">

    <form class="login-form database_operation" action="{{url('/loginPro')}}" method="post">
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" name="email" class="form-control" placeholder="Enter Your Email" autofocus>
          {{csrf_field()}}
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <label class="checkbox">
                <span class="pull-right"><a href="#" style="margin-left:10px;"> Forgot Password?</a></span>
            </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
      </div>
    </form>
  </div>
  <script src="{{url('js/jquery.js')}}"></script>
  <script>
        $(document).ready(function(){
            $('.database_operation').submit(function(){
                var data = $(this).serialize();
                var url = $(this).attr('action');
                $.post(url,data,function(data,status){
                    if(data.status == true){
                        window.location.href = data.url
                    }else{
                        alert(data.msg);
                    }
                });
                return false;
            });
        });
</script>
</body>

</html>
