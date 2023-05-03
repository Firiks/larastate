<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Larastate, simple realestate application">
    <meta name="keywords" content="realestate, larastate">
    <meta name="author" content="Larastate">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="google" content="notranslate">
    <meta property="og:type" content="website">
    <meta name="google-site-verification" content="google-site-verification=google-site-verification">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{!! '@larastate' !!}">
    <meta name="twitter:creator" content="{!! '@larastate' !!}">
    <link rel="icon" href="{{ public_path('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <title>Larastate</title>
    @routes
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @inertiaHead
</head>
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300">
    @inertia
</body>
</html>
