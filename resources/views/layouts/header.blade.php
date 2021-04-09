<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Instant News Admin Panel">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>{{$title}}</title>
  <link href="{{url('public/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{url('public/css/bootstrap-theme.css')}}" rel="stylesheet">
  <link href="{{url('public/css/elegant-icons-style.css')}}" rel="stylesheet" />
  <link href="{{url('public/css/font-awesome.min.css')}}" rel="stylesheet" />
  <link href="{{url('public/css/style.css')}}" rel="stylesheet">
  <link href="{{url('public/css/style-responsive.css')}}" rel="stylesheet" />
  
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->

    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="{{url('/dashboard')}}" class="logo">Instant <span class="lite">News</span></a>
      <!--logo end-->

      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">

          
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="" style="height:20px;width:20px;" src="{{url('public/img/user_img.webp')}}">
                            </span>
                            @if(Session::has('name'))
                            <span class="username">{{Session::get('name')}}</span>
                            @endif

                            <b class="caret"></b>
                        </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <li>
                <a href="{{url('/logout')}}"><i class="icon_key_alt"></i> Log Out</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </header>
<aside>
      <div id="sidebar" class="nav-collapse ">
        <ul class="sidebar-menu">
          <li class="">
            <a class="" href="{{url('/dashboard')}}">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
          </li>
          
          <li class="sub-menu">
            <a href="{{url('/category')}}" class="">
                          <i class="icon_table"></i>
                          <span>Trending Category</span>
                      </a>
          </li>
          <li class="sub-menu">
            <a href="{{url('/authers')}}" class="">
                          <i class="icon_table"></i>
                          <span>Authers</span>
                      </a>
          </li> 
          <li class="sub-menu">
            <a href="{{url('/withdraw')}}" class="">
                          <i class="icon_document_alt"></i>
                          <span>Withdraw</span>
                      </a>
          </li>
          
          <li>
            <a class="" href="{{url('/authersPost')}}">
                          <i class="icon_genius"></i>
                          <span>Post By Author</span>
                      </a>
          </li>
          <li class="sub-menu">
            <a href="{{url('/registerAdmin')}}" class="">
                          <i class="icon_table"></i>
                          <span>Make Admin</span>
                      </a>
          </li> 

        </ul>
      </div>
    </aside>