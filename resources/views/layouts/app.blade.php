<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The CheckIn') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/datatables.min.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script src="{{ asset('dist/dropzone/dist/dropzone.js') }}"></script>
    
</head>
@guest
<body class="login">
@else
<body class="main">
@endguest

@yield('content')

<script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>

<script src="{{ asset('dist/js/app.js') }}"></script>
<script type="text/javascript">
   var baseurl = '{{ url('/'); }}';
</script>
<script src="{{ asset('dist/js/datatables.min.js') }}"></script>
<script src="{{ asset('dist/js/custom.js') }}"></script>


</body>
</html>
