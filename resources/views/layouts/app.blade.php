<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken'=> csrf_token(),
            'user'=> [
                'authenticated' => auth()->check(),
                'id' => auth()->check() ? auth()->user()->id : null,
                'name' => auth()->check() ? auth()->user()->name : null, 
                ]
            ])
        !!};
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://unpkg.com/vue-ckeditor2"></script>
    <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('inc.navbar');

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
</body>
</html>
