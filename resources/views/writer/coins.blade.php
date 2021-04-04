@include('writer.header',["title" => "Amount"])

    <div class="row">
        <div class="col-md-12 my-5" style="margin-left: 1%;">
            <h3>Amount History</h3>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>likes</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="authershistory">
                    
                </tbody>
            </table>
            <button class="btn btn-primary" id="prev">Previous</button> <span><button class="btn btn-primary" id="next">Next</button></span>
        </div>
    </div>

@include('writer.footer')
<script>
    $(document).ready(function(){
        localStorage.setItem('page',1);
        getAutherHistory();
        function getAutherHistory(){
            var page = localStorage.getItem('page');
            var url = `{{ url('/auther/getAutherHistory/${page}') }}`;
            $.get(url,function(data,status){
                if(data.status){
                    var st = ``;
                    var key = 0;
                    if(data.data.length == 0){
                        st = `<h4>No Data Found!!</h4>`;
                    }
                    (data.data).forEach(element => {
                        st+= `<tr>
                                <td>${key+1}</td>
                                <td>${element.category}</td>
                                <td>${element.title}</td>
                                <td>${element.content}</td>
                                <td>${element.likes}</td>
                                <td>Rs- <span>${element.amount}</span></td>
                            </tr>`;
                    });
                }else{
                    st = `<h4>${data.msg}</h4>`;
                }

                $('#authershistory').html(st);
            });
        }

        $('#prev').click(function(){
            var page = localStorage.getItem('page');
            page = page-1;
            if(page == 0){
                alert("No Data On this Url!!");
            }else{
                localStorage.setItem('page',page);
                getAutherHistory();
            }
        });
            
        

        $('#next').click(function(){
            var page = localStorage.getItem('page');
            localStorage.setItem('page',parseInt(page)+1);
            getAutherHistory();
        })

    });
</script>