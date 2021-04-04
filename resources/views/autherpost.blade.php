@include('layouts/header',['title'=>'Author Post'])
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Author Post</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Author Post</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="margin-top:4%;">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <td>Sr No</td>
                        <td>Category</td>
                        <td>Author</td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Image</td>
                        <td>SourceURL</td>
                        <td>Date</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="authorsPostData">
                    
                </tbody>
            </table>
            <button class="btn btn-primary" id="prev">Previous</button> <span><button class="btn btn-primary" id="next">Next</button></span>
          </div>
        </div>
      </section>
    </section>
  </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Amount To Auther</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{ url('/approvePost') }}" class="database_operation">
                <div>
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control" name="amount" placeholder="Enter Amount">
                    <input type="hidden" name="auther_id" id="auther" value="">
                    <input type="hidden" name="news_id" id="news" value="">
                    <input type="hidden" name="category" id="category" value="">
                    {{ csrf_field() }}
                </div>
                <button class="btn btn-primary" style="margin-top: 1%;">Save</button>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@include('layouts.footer')
<script>
    $(document).ready(function(){
        localStorage.setItem('page',1);
        getautherData();
        function getautherData(){
            var page = localStorage.getItem('page');
            var url = `{{ url('/getautherData/${page}') }}`;
            $.get(url,function(data,status){
                var st = '';
                if(data.status){
                    if((data.data).length == 0){
                        st = `<h4>No Data Found!!</h4>`;
                    }
                    var key = 0;
                    (data.data).forEach(element => {
                        st+= `<tr>
                                    <td>${key+1}</td>
                                    <td>${element.category}</td>
                                    <td>${element.author}</td>
                                    <td>${element.title}</td>
                                    <td>${element.content}</td>
                                    <td><a href="${element.imgsrc}" target="_blank">View</a></td>
                                    <td><a href="${element.sourceURL}" target="_blank">View</a></td>
                                    
                                    <td>${element.postedAt}</td>
                                    <td><button class="btn btn-primary approve" style="margin-right: 1%;" news-id="${element.id}" data-id="${element.writtenBy}" category="${element.category}" data-toggle="modal" data-target="#exampleModal" >Approve</button><a href="{{ url('/deleteAuthersPost/${element.id}/${element.category}') }}" class="btn btn-danger">Delete</a></td>
                                </tr>`;
                                key+=1;
                    });
                }else{
                    alert(data.msg);
                    st = `<h3>${data.msg}</h3>`;
                }
                $('#authorsPostData').html(st);
                $('.approve').click(function(){
                    var auther_id = $(this).attr('data-id');
                    var news_id = $(this).attr('news-id');
                    var category = $(this).attr('category');
                    $('#auther').val(auther_id);
                    $('#news').val(news_id);
                    $('#category').val(category);
                });
            });
        }

        $('#prev').click(function(){
            var page = localStorage.getItem('page');
            page = page-1;
            if(page == 0){
                alert("No Data On this Url!!");
            }else{
                localStorage.setItem('page',page);
                getautherData();
            }
        });
            
        

        $('#next').click(function(){
            var page = localStorage.getItem('page');
            localStorage.setItem('page',parseInt(page)+1);
            getautherData();
        });
            
        $('.database_operation').submit(function(){
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.post(url,data , function(data , status){
                if(data.status){
                    alert(data.msg)
                    window.location.href = `{{ url('/authersPost') }}`;
                }else{
                    alert(data.msg)
                }
            });
            return false;
        });

    });
</script>