<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="hanabishi japon,bistronippon, currykitano">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Hanabishi Japan</title>
    
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/offcanvas.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/fumi.css') }}" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LTR7FBVN7P"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-LTR7FBVN7P');
    </script>
    
  </head>
    <body class="bg-light">
    @yield('head')
    @env('local')
      <div class="m-2"><h3>ローカル環境</h3></div>                
    @endenv
    @yield('content')
    @yield('footer')
    </body>
</html>
