<!DOCTYPE html>
<html lang="en">
@include('wizmoto.partials.head')

<body class="@yield('body-class')">

<div class="boxcar-wrapper @yield('main-div')">
    @yield('content')
</div>
@include('wizmoto.partials.scripts')
@stack('scripts')
</body>
