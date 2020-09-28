<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>
    <link rel="stylesheet" href="/css/app.css">

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <link rel="stylesheet" href="/css/roboto.min.css">
    <link rel="stylesheet" href="/css/material.min.css">
    <link rel="stylesheet" href="/css/ripples.min.css">
</head>
<body>

    @include('shared.navbar')

    @yield('content')

    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery-3.4.1.min.js"></script>

    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>

    <script>
        $(document).ready(function() {
            // This command is used to initialize some elements and make them work properly
            $.material.init();
        });
    </script>
</body>
</html>
