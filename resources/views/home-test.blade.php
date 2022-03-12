<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

</head>

<body style="overflow: hidden !important;">

    <div id="app"></div>

    <script>
        var route = '{{ $route ?? '
        home;
        '}}';
    </script>
    <script rel="preload" as="script" src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>