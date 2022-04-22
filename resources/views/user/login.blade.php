<?php
?>

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Events</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h1>Авторизация и регистрация</h1>

        <form action="/auth" method="get">
            @csrf
            <div>{{ $errors->event->first('email') }}</div>
            <div>{{ $errors->event->first('password') }}</div>
            <input type="text" placeholder="Имя" name="email"><br>
            <input type="email" placeholder="E-mail" name="email"><br>
            <input type="email" placeholder="Пароль" name="password"><br>
            <input type="submit" value="Авторизоваться">
        </form>

        <form action="/register" method="post">
            @csrf
            <div>{{ $errors->event->first('name') }}</div>
            <div>{{ $errors->event->first('email') }}</div>
            <div>{{ $errors->event->first('password') }}</div>
            <div>{{ $errors->event->first('password_check') }}</div>
            <input type="text" placeholder="Имя" name="name"><br>
            <input type="email" placeholder="E-mail" name="email"><br>
            <input type="password" placeholder="Пароль" name="password"><br>
            <input type="password" placeholder="Повторите пароль" name="password_check"><br><br>
            <input type="submit" value="Зарегестрироваться">
        </form>
    </div>
</div>
</body>
</html>


