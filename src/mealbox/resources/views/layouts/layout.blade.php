<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <!-- Scripts -->
  <script src="{{ secure_asset('/js/app.js') }}" defer></script>
  <!-- Styles -->
  @if (app('env') == 'production')
    <link href="{{ secure_asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('/css/home.css') }}" rel="stylesheet">
  @else
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/home.css') }}" rel="stylesheet">
  @endif
</head>
<body>
  @include('shared.header')
  @yield('content')

</body>
</html>