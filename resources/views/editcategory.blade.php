@include('layouts/header',['title'=>'Edit Trending News Category'])
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Edit Trending News Category</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Edit Trending News Category</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <div class="col-md-2"></div>
          <div class="col-md-8">
          <?php $id = Request::segment(2); ?>
          <?php  if(isset($_GET['msg'])){
              ?>
                    <div style="color:red;"><?php echo $_GET['msg']; ?></div>
                    <script>
                        setTimeout(() => {
                            window.location.href = {{url('/editCategory')}}
                        }, 3000);
                    </script>
              <?php
          } ?>
            
            <form action="{{url('/editCategoryProcess')}}" class="database_operation" enctype='multipart/form-data' method="post">
                <div>
                    <label for="name">Category:</label>
                    <input type="text" placeholder="Enter Category Name" class="form-control" name="category" value="{{$category->category}}" required>
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div>
                    <label for="title">Title:</label>
                    <input type="text" placeholder="Enter Title Of Category" class="form-control" value="{{$category->title}}" required name="title">
        
                </div>
                <div>
                    <label for="name">Image:</label>
                    <input type="file" name="img" id="image" class="form-control">
                </div>
                <button class="btn btn-primary" style="margin-top:2%;">Save</button>
            </form>
          </div>
          <div class="col-md-2"></div>
          </div>
        </div>
      </section>
    </section>
  </section>
