<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ AppSetting('title') }} - Reflexology & Massage Therapy. </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Reflexology & Massage Therapy" name="description" />
    <meta content="You Lian tAng" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/')."/". AppSetting('favicon') }}">
    @include('layouts.head')
</head>

@yield('body')

<div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div>

@yield('content')

@include('layouts.footer-script')

</body>

</html>
