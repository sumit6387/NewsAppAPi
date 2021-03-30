@include('layouts/header',['title'=>'Register Admin'])
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Dashboard</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Register Admin</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="margin-top:4%;">
           <div class="col-md-3"></div>
           <div class="col-md-6">
                <form action="/register" class="database_operation">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter Email">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    </div>
                    <div class="my-5" style="margin-top: 4%;">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
           </div>
           <div class="col-md-3"></div>
          </div>
        </div>
      </section>
    </section>
  </section>

@include('layouts.footer')
<script>
    $(document).ready(function(){
        var mainUrl = "{{url('/')}}";
        $('.database_operation').submit(function(){
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.post(mainUrl+url,data,function(data,status){
                if(data.status ==true){
                    alert(data.msg)
                    $('.form-control').val('');
                }else{
                    alert(data.msg);
                }
            });
            return false;
        });
    });
</script>