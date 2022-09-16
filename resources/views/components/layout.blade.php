<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
<body>
    {{ $slot }}
    <script>
        @if(session()->has('message'))
        alert("{{ session('message') }}")
        @endif
    </scripT>
</body>
</html>
