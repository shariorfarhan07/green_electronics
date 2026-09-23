<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Green Electronics') }}</title>
    <meta name="description" content="Green Electronics — Bangladesh's electronics component store for Arduino, sensors, robotics, 3D printing and more.">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

@inertia

<script src="{{ asset('js/inertia.js') }}" defer></script>
</body>
</html>
