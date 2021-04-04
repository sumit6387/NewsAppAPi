@include('layouts/header',['title'=>'Withdraw'])
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Withdraw</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Withdraw</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="margin-top:2%;">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Mode</th>
                        <th>Mobile No/UPI Id</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="withdraw_data">
                    
                </tbody>
            </table>
            <button class="btn btn-primary" id="prev">Previous</button> <span><button class="btn btn-primary" id="next">Next</button></span>
          </div>
        </div>
      </section>
    </section>
  </section>

@include('layouts.footer')
<script>
    $(document).ready(function(){
        localStorage.setItem('page',1);
        getwithdrawData();
         function getwithdrawData(){
             var page = localStorage.getItem('page');
             var url = `{{ url('/getwithdrawData?page=${page}') }}`;
             $.get(url,function(data,status){
                if(data.status){
                    if((data.data.data).length == 0){
                        st = `<h4>No Data Found!!</h4>`;
                    }
                    var key = 0;
                    var st = '';
                    (data.data.data).forEach(element => {
                        st += `<tr>
                                <td>${key+1}</td>
                                <td>${element.name}</td>
                                <td>${element.mode}</td>
                                <td>${element.mobile_no}</td>
                                <td>${element.amount}</td>
                                <td><a href="{{ url('/withdrawDone/${element.id}') }}" class="btn btn-primary">Done</a></td>
                            </tr>`;
                            key += 1;
                    });
                    $('#withdraw_data').html(st);
                }else{
                    alert(data.msg)
                }
             });    
         }

         $('#prev').click(function(){
            var page = localStorage.getItem('page');
            page = page-1;
            if(page == 0){
                alert("No Data On this Url!!");
            }else{
                localStorage.setItem('page',page);
                getwithdrawData();
            }
        });
            
        

        $('#next').click(function(){
            var page = localStorage.getItem('page');
            localStorage.setItem('page',parseInt(page)+1);
            getwithdrawData();
        });
    });
</script>