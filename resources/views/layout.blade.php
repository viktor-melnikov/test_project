<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transfer Money</title>

    <link rel="stylesheet" href="{{ asset_vendor('bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset_vendor('select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset_dist('css/build.css') }}">
</head>
<body>

    @yield('content')

<script src="{{ asset_vendor('jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset_vendor('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset_vendor('select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset_vendor('jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset_vendor('jquery-validation/src/localization/messages_ru.js') }}"></script>

<script src="{{ asset_dist('js/app.js') }}"></script>

</body>
</html>