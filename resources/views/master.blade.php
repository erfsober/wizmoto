<!DOCTYPE html>
<html lang="en">
@include('wizmoto.partials.head')
@stack('styles')
<body class="@yield('body-class')">

<div class="boxcar-wrapper @yield('main-div')">
    @yield('content')
</div>
@stack('before-scripts')
@include('wizmoto.partials.scripts')
@stack('scripts')
</body>
