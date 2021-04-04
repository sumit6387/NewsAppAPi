@include('writer.header',["title" => "Withdraw"])
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="{{ url('/auther/withdrawProcess') }}" class="database_operation" style="margin-top:3%;">
                <div>
                    <label for="mode">Mode</label>
                    <select class="form-control" name="mode">
                        <option value="gpay">G Pay</option>
                        <option value="phonepe">Phone Pe</option>
                        <option value="paytm">Paytm</option>
                        <option value="upi">UPI</option>
                    </select>
                </div>
                <div>
                    <label for="mobile">Mobile No/UPI Id</label>
                    <input type="text" name="mobile_no" class="form-control" placeholder="Enter Your G Pay/Phone Pe/Paytm No or UPI Id">
                    {{ csrf_field() }}
                </div>
                <div>
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" placeholder="Enter Amount" class="form-control">
                </div>
                <div>
                    <button class="btn btn-primary btn-block my-3">Withdraw</button>
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
                    alert(data.msg);
                    window.location.href = `{{ url('/auther/withdraw') }}`;
                }else{
                    alert(data.msg);
                }
            });
            return false;
        });
    });
</script>