<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Auther Login</title>
    <style>
        body{
            background-color: rgb(116, 179, 252);
        }
    </style>
  </head>
  <body>
    <div style="margin:10% 15% 30% 25%;background-color:rgb(152, 200, 255);border-radius:25px;">
      <h3 class="text-center">Auther Login</h3>
      <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                    <form action="{{ url('/auther/autherLogin') }}" id="database_operation" style="margin-bottom: 10%;">
                      <div>
                          <label for="email">Email:</label>
                          <input type="email" placeholder="Enter Your Email" name="email" class="form-control">
                          {{ csrf_field() }}
                      </div>
                      <div>
                        <label for="email">Password:</label>
                        <input type="password" placeholder="Enter Your Password" name="password" class="form-control">
                    </div>
                    <button class="btn btn-primary my-3">Login</button>
                    <span>
                      <a href="#" style="margin-left: 15%;" data-toggle="modal" data-target="#exampleModal">Forgot Password</a>
                    </span>
                    <br>
                    
                    </form>
                  </div>
                  <div class="col-md-1"></div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Forget Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ url('/auther/forgetPassword') }}" class="database_operation">
              <div>
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Registered Email" required>
                {{ csrf_field() }}
              </div>
              <button class="btn btn-primary my-3">Send Email</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#database_operation').submit(function(e){
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.post(url,data,function(data,status){
                    if(data.status){
                        window.location.href = `{{ url('/auther/dashboard') }}`;
                    }else{
                        alert(data.msg)
                    }
                });
                return false;
            });

            $('.database_operation').submit(function(){
              var data = $(this).serialize();
              var url = $(this).attr('action');
              $.post(url,data,function(data,status){
                if(data.status){
                  alert(data.msg);
                  window.location.href= `{{ url('/auther/auther-login') }}`;
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