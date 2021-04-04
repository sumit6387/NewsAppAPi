<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Change Password</title>
  </head>
  <body>
      <div class="row my-5">
          <div class="col-md-3"></div>
          <div class="col-md-6">
              <h2>Change Password</h2>
              <form action="{{ url('/auther/changeForgetPassword') }}" class="database_operation">
                <div>
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter New Password">
                </div>
                    @php
                        $email = Request::segment(3);
                    @endphp
                <div>
                    <label for="cnf_password">Confirm Password</label>
                    <input type="password" name="cnf_password" class="form-control" placeholder="Enter Confirm Password">
                    <input type="hidden" name="email" value="{{ $email }}">
                    {{ csrf_field() }}
                    
                </div>
                <button class="btn btn-primary my-3">Change Password</button>
            </form>
            
          </div>
          <div class="col-md-3"></div>
      </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('.database_operation').submit(function(){
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.post(url,data,function(data,status){
                    console.log(data)
                    if(data.status){
                        alert(data.msg);
                        window.location.href = `{{ url('/auther/auther-login') }}`;
                    }else{
                        alert(data.msg)
                    }
                });
                return false;
            });
        });
    </script>
  </body>
</html>