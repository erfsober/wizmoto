<head>
    <meta charset="utf-8">
    <title>Wizmoto</title>
    <!-- Stylesheets -->
    <link href="{{ asset('wizmoto/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('wizmoto/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('wizmoto/css/slick.css') }}">
    <link href="{{ asset('wizmoto/css/mmenu.css') }}" rel="stylesheet">
    <link href="{{ asset('wizmoto/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('wizmoto/css/jquery-ui.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{asset("wizmoto/images/favicon.png")}}" type="image/x-icon">
    <link rel="icon" href="{{asset("wizmoto/images/favicon.png")}}" type="image/x-icon">
    
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!-- Chat Configuration - Must be loaded before any JavaScript -->
    @stack('chat-config')
</head>