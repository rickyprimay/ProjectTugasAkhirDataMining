<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha384-ZyGhL1fGj5sR6OwgoFBw9E7Zn7fQ5KU6+3Hd3gGq7S37KohE7/hBGgFG5dJ3Ed+5" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" href="{{ asset("assets/image/logo/recycle.jpg") }}">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <title>Smart Waste Classifier</title>
</head>
<body>
  @include('dashboard.components.sidebar')
  @yield('content')
  @include('dashboard.components.footer')

  @include('sweetalert::alert')

  <script>
    AOS.init();
  </script>
</body>
</html>
