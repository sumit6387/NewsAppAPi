<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>{{ $title }}</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/auther/dashboard') }}">Auther Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"         data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{ url('/auther/dashboard') }}">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('/auther/writeNews') }}">Write News</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('/auther/changepassword') }}">Change Password</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('/auther/coins') }}">History</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/auther/withdraw') }}">Withdraw</a>
            </li>
          </ul>
          <span class="navbar-text" style="margin-right:5%;">
            Amount : <span style="color: rgb(212, 38, 38);">{{ Session::get('amount') }}</span>
          </span>
          <span class="navbar-text">
            <a href="{{ url('/auther/logout') }}" style="text-decoration: none;">Logout</a>
          </span>
        </div>
      </nav>