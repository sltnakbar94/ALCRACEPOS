<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Slim">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/slim/img/slim-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/slim">
    <meta property="og:title" content="Slim">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>ALC Race - POS</title>

    <!-- Vendor css -->
    <link href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">

    <!-- Slim CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/slim.css') }}">

  </head>
  <body>

    <div class="d-md-flex flex-row-reverse">
      <div class="signin-right">

        {{ Form::open(['route' => 'login','autocomplete' => 'off']) }}
        <div class="signin-box">
          <h2 class="signin-title-primary">Selamat Datang!</h2>
          <h3 class="signin-title-secondary">Login untuk melanjutkan.</h3>

          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Masukan username">
            <span class="text-danger">{{ $errors->first('email') }}</span>
          </div>
          <div class="form-group mg-b-50">
            <input type="text" maxlength="6" style="-webkit-text-security: disc;"  class="form-control" name="password" placeholder="Masukan pin">
            <span class="text-danger">{{ $errors->first('password') }}</span>
          </div>
          <button class="btn btn-primary btn-block btn-signin">Masuk</button>
        </div>
        {{ Form::close() }}

      </div><!-- signin-right -->
      <div class="signin-left">
        <div class="signin-box">
          <h2 class="slim-logo"><a href="index.html">ALC <small>POS</small></a></h2>

          <p>We are excited to launch our new company and product Slim. After being featured in too many magazines to mention and having created an online stir, we know that ThemePixels is going to be big. We also hope to win Startup Fictional Business of the Year this year.</p>

          <p>Browse our site and see for yourself why you need Slim.</p>


          <p class="tx-12">&copy; Copyright {{ date('Y') }}. All Rights Reserved.</p>
        </div>
      </div><!-- signin-left -->
    </div><!-- d-flex -->

    <script src="{{ asset('assets/lib/jquery/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/lib/popper.js/js/popper.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.js') }}"></script>

    <script src="{{ asset('assets/js/slim.js') }}"></script>

  </body>
</html>
