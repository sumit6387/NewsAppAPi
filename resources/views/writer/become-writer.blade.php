<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Instant News - Become Auther</title>
    <style>
        body{
            background-color : #c9d1cb;
            overflow: hidden;
        }
        span{
            color:red;
        }
    </style>
  </head>
  <body>
    <h1 align="center" class="my-4">Become Auther In Instant News </h1>

    <div class="row my-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url('learner/becomeAuther')}}" method="post" class="database_operation">
                    <div class="form-group">
                        <label for="name">Name<span>*</span></label>
                        <input type="text" name="name" placeholder="Enter Your Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span>*</span></label>
                        <input type="email" name="email" placeholder="Enter Your Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mobileno">Mobile Number<span>*</span></label>
                        <input type="text" name="mobile_no" placeholder="Enter Your Mobile Number" class="form-control">
                        {{csrf_field()}}
                    </div>
                    <div class="form-group">
                        <label for="blog">Blog Article Link<span>*</span> or below</label>
                        <input type="text" name="blog_link" placeholder="Enter Any Blog Link That You Written." class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="blog">Social Link<span>*</span> or above</label>
                        <input type="text" name="social_link" placeholder="Enter Any Social Link That You Written." class="form-control">
                    </div>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-3"></div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('.database_operation').submit(function(){
                var url = $(this).attr('action');
                var data = $(this).serialize();

                $.post(url , data , function(data,status){
                    if(data.status){
                        $('.form-control').val('');
                        alert(data.msg)
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