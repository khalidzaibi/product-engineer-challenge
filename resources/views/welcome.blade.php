<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Engineer</title>
    @vite('resources/js/app.js')
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="app"></div>
</body>

</html>