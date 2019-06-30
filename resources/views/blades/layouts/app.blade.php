<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') . ($title ?? null ? ' - ' . $title : '')  }}</title>

        <!--Favicon-->
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <link rel="shortcut icon" type="image/png" href="{{url('/favicon.png')}}"/>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = {csrfToken: '{{csrf_token()}}'}</script>

        <noscript>
            <strong>We're sorry but {{config('app.name', 'Laravel')}} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <!-- SEO & Sharing -->
        <meta name="google-site-verification" content="8nCz107fSRx1WTGVeWqFVOq8-vBG5bs_1cvdE9CMS2Q" />
        <meta name="description" content="{{$description ?? 'Free Crowdfunding platform'}}">
        <meta property="og:description" content="{{$description ?? 'Free Crowdfunding platform!'}}">
        <meta property="og:url" content="{{Request::url()}}"/>
        <meta property="og:title" content="{{$title ?? env("APP_NAME")}}"/>
        <meta property="og:type" content="website"/>
        <meta property="fb:app_id" content="615755662100569">
        <meta name="google-site-verification" content="13JatL80lz_cF0r0EIcpiDXJM2MeywM0gfjQN7tnerA" />
        <meta property="og:image" content="https://powershare.fund/img/pwrshr_alpha_logo.png">
        
    </head>

    @yield('body')

    <script src="{{mix('js/app.js')}}"></script>


</html>