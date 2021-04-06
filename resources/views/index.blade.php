@include('layouts/header',['title'=>'Dashboard'])
<style>
  .index-card{
    background-color: rgb(255, 254, 254);
    border-radius:10px;
    padding-top: 2%;
    padding-bottom: 10%;
  }
  .headings{
    text-align: center;
  }
</style>
<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Dashboard</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{url('/dashboard')}}">Home</a></li>
              <li></i>Dashboard</li>
            </ol>
          </div>
        </div>
        <div class="row" style="margin-top:2%;">
          <div class="col-md-4">
            <div class="index-card">
              <div>
                <h3 class="headings">No Of Registered User / Downloads</h3>
                <h4 class="headings" id="registerUsers" style="color: black;">{{ $users }}</h4>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="index-card">
              <div>
                <h3 class="headings">No Of Auther</h3>
                <h4 class="headings" id="authers" style="color: black;">{{ $authers }}</h4>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="index-card">
              <div>
                <h3 class="headings">No Of Trending News</h3>
                <h4 class="headings" id="trendingNews" style="color: black;">{{ $trendingNews }}</h4>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
  </section>

@include('layouts.footer')