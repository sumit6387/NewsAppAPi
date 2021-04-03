    @include('writer.header',['title' =>'Auther Dashboard'])
    <div style="margin-left:2%;margin-right:2%;margin-top:2%;">
        <h3>All News Written By You</h3>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <td>Sr No</td>
                    <td>Category</td>
                    <td>Title</td>
                    <td>Description</td>
                    <td>Date</td>
                    <td>Likes</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($trendingNews as $key => $news)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $news->category }}</td>
                        <td>{{ $news->title }}</td>
                        @php
                            $len = strlen($news->content);
                            $string = substr($news->content,0,($len*40)/100);
                        @endphp
                        <td>{{ $string }}......</td>
                        <td>{{ $news->postedAt }}</td>
                        @php
                            if($news->likes == null){
                                $likes = 0;
                            }else{
                                $arr = explode(',',$news->likes);
                                $likes = count($arr)-1;
                            }
                            $status = 'pending';
                            if($news->status == 1){
                                $status = 'approved';
                            }
                        @endphp
                        <td>{{ $likes }}</td>
                        <td>{{ $status }}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>

    @include('writer.footer')
  </body>
</html>