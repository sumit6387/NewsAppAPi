@include('layouts/header',['title'=>'Trending News Category'])
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Trending News Category</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Trending News Category</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <button class="btn btn-primary" style="margin-left:89.5%;"  data-toggle="modal" data-target="#exampleModal">Add New Category</button>
            <table class="table table-hovered table-bordered" style="margin-top:2%;">
                <thead>
                    <tr>
                        <td>Sr No</td>
                        <td>Category Name</td>
                        <td>Title</td>
                        <td>Image</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="authers_data">
                    @foreach($categories as $key=> $category)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$category->category}}</td>
                            <td>{{$category->title}}</td>
                            <td><a href="{{url('public/uploads/category/'.$category->img)}}" target="_blank">View</a></td>
                            <td><a href="{{url('/editCategory/'.$category->id)}}" class="btn btn-primary" style="margin-right:1%;">Edit</a><span><a href="{{url('/deleteCategory/'.$category->id)}}" class="btn btn-danger">Delete</a></span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                <form action="{{url('/addCategory')}}" class="database_operation" enctype='multipart/form-data' method="post">
                                    <div>
                                        <label for="name">Category:</label>
                                        <input type="text" placeholder="Enter Category Name" class="form-control" name="category" required>
                                        {{csrf_field()}}
                                    </div>
                                    <div>
                                        <label for="title">Title:</label>
                                        <input type="text" placeholder="Enter Title Of Category" class="form-control" required name="title">
    
                                    </div>
                                    <div>
                                        <label for="name">Image:</label>
                                        <input type="file" name="img" id="image" class="form-control" required>
                                    </div>
                                    <button class="btn btn-primary" style="margin-top:2%;">Save</button>
                                </form>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
@include('layouts.footer')