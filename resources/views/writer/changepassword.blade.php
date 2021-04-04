@include('writer.header',['title' => "Change Password"])
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" style="margin:4% 10% 10% 10%;">
            <h2>Change Password</h2>
            <form action="{{ url('auther/changePasswordProcess') }}" class="database_operation">
                <div>
                    <label for="new_password">New Password</label>
                    <input type="text" class="form-control" placeholder="Enter New Password" name="new_password">
                    {{ csrf_field() }}
                </div>
                <div>
                    <label for="new_password">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Confirm Password" name="cnf_password">
                </div>
                <div>
                    <button class="btn btn-primary btn-block my-3">Change</button>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>

@include('writer.footer')
<script>
    $(document).ready(function(){
        $('.database_operation').submit(function(){
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.post(url,data,function(data,status){
                if(data.status){
                    $('.form-control').val('');
                    alert(data.msg)
                }else{
                    alert("oops! "+data.msg);
                }
            });
            return false;
        });
    });
</script>
</body>
</html>