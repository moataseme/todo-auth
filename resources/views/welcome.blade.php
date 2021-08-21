<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Todo List With Auth</title>
    </head>
    <body class="antialiased">
        <div id="app">
            <app-header></app-header>
            <router-view></router-view>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>
