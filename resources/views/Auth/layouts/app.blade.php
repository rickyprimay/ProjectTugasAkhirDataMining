<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset("assets/image/logo/recycle.jpg") }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Smart Waste Classifier</title>
</head>
<body>
  @yield('content')

  @include('sweetalert::alert')
</body>
</html>
