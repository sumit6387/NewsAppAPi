@include('writer.header',['title' =>'Write News'])

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 my-2">
        <form action="{{ url('/auther/submit-post') }}" enctype="multipart/form-data" method="POST">
            <?php
                if(isset($_GET['msg'])){
                    ?>
                    <div style="color: red;">{{ $_GET['msg'] }}</div>
                    <script>
                        setTimeout(() => {
                            window.location.href = `{{ url('/auther/writeNews') }}`;
                        }, 2000);
                    </script>
            <?php
                }
            ?>
            <div>
                <label for="category">Category</label>
                <select class="form-control" name="category">
                    <option value="">Default</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="category">Trending Category</label>
                <select class="form-control" name="trendingCategory">
                    <option value="">Default</option>
                    @foreach ($trenndingCategories as $trendingcategory)
                        <option value="{{ $trendingcategory->category }}">{{ $trendingcategory->category }}</option>
                    @endforeach
                </select>
            </div>
            @php
                $title = '';
                $desc = '';
                if(Session::get('title')){
                    $title = Session::get('title');
                }
                if(Session::get('description')){
                    $desc = Session::get('description');
                }
            @endphp
            <div>
                <label for="title">Title</label>
                <input type="text" class="form-control" value="{{ $title }}" name="title">
                {{ csrf_field() }}
            </div>
            <div>
                <label for="sourceurl">Source Url</label>
                <input type="text" class="form-control" name="sourceURL">
            </div>
            <div>
                <label for="image">Image</label>
                <input type="file" class="form-control" name="img">
            </div>

            <div>
                <label for="desc">Description   <span style="margin-left:550%;color:rgb(21, 125, 243);" id="length">0/70</span></label>
                <textarea name="description" id="desc" class="form-control" value="{{ $desc }}" style="height: 10%;" cols="30" rows="10"></textarea>
                <small>Maximum 70 words</small>
            </div>
            <button class="btn btn-primary btn-block my-2">Submit</button>
        </form>
        </div>
        <div class="col-md-3"></div>

    </div>



@include('writer.footer')
<script>
    $(document).ready(function(){
        $('.btn-block').click(function(){
            $('#desc').prop('disabled',false);
        });
        $('#desc').on('input', function() {
            var str = $(this).val();
            var arr = str.split(' ');
            var len = arr.length-1 + "/70";
            if(arr.length > 70){
                alert('You Can Not Write More Then 70 Words!')
                $(this).prop('disabled',true);
            }else{
                $('#length').html(len);
            }
        });
    });
</script>
</body>
</html>