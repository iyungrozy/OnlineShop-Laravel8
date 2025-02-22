<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9 no-js" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') | A&A Store Online</title>
  <link rel="stylesheet" href="{{url('polished/css/polished.min.css')}}">
  <link rel="stylesheet" href="{{url('polished/css/open-iconic-bootstrap.min.css')}}">

  <link rel="icon" href="{{url('polished/assets/fav.png')}}">

  <style>
    
  </style>

</head>

<body>


  <div class="container-fluid h-100 p-0">
    <img src="{{url('polished/assets/ngapak.png')}}" height="100">
    <hr class="bg-secondary mb-1">
    <small>
    A&A Store &copy; 2024 All Reserved.
        <span class="oi oi-phone"> </span>
        <span class="oi oi-envelope-closed"></span>
    </small>
    <hr class="bg-secondary mt-1">
      @yield('content')
  </div>

  
</body>

</html>