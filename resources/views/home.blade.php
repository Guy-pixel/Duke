<?php
?>
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
<body>
@if(!Auth::check())
    <form action="/login" method="post">
        @csrf
        <input type="text" name="username">
        <input type="password" name="password">
        <button type="submit">Login</button>
    </form>
@else
    <form action="/logout" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endif
<div>
    @if(Auth::check())
        You are currently logged in as {{ Auth::user()->username }}
    @endif
</div>


<script>
    @if(session()->has('message'))
    alert("{{ session('message') }}")
    @endif
</script>
</body>
</html>

