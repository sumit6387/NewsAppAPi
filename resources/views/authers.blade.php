@include('layouts/header',['title'=>'Auther'])
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Auther</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Auther</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-hovered table-bordered">
                <thead>
                    <tr>
                        <td>Sr No</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Mobile Number</td>
                        <td>Blog Article</td>
                        <td>Social Link</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="authers_data">
                    
                </tbody>
            </table>
          </div>
        </div>
      </section>
    </section>
  </section>

@include('layouts.footer')
<script>
   var url = "{{url('/getAuther')}}";
    $(document).ready(function(){
        $.get(url,function(data,status){
            console.log(data.data.data)
            if(data.status){
                var st = '';
                var key = 1;
                if((data.data.data).length > 0){
                    data.data.data.forEach(element => {
                        st += `<tr>
                            <td>${key}</td>
                            <td>${element.name}</td>
                            <td>${element.email}</td>
                            <td>${element.mobile_no}</td>
                            <td><a href="${element.blog_article}" target="_blank">View</a></td>
                            <td><a href="${element.social_link}" target="_blank">View</a></td>
                            <td><a  href="{{url('/acceptAutherRequest/${element.auther_id}')}}" class="btn btn-primary">Accept</a><span><a href="{{url('/deleteAuther/${element.auther_id}')}}" class="btn btn-danger" style="margin-left:1%;">Delete</a></span></td>
                        </tr>`;
                        key += 1;
                    });
                }else{
                    st = "No Data Found!!";
                }
                $('#authers_data').html(st);

            }else{
                alert(data.msg);
            }

        });
    });
</script>