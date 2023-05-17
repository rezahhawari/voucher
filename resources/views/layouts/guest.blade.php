<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('toastify-js/src/toastify.css')}}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        <script src="{{asset('admin/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('toastify-js/src/toastify.js')}}"></script>
        @if (Session::has('success'))
            <script>
                $(document).ready(function(){
                    Toastify({
                        text: "<?php echo Session::get('success') ?>",
                        duration: 3000,
                        style: {
                            background: "green",
                        }
                    }).showToast();
                })
            </script>
        @endif

        @if (Session::has('fail'))
            <script>
                $(document).ready(function(){
                    Toastify({
                        text: "<?php echo Session::get('fail') ?>",
                        duration: 3000,
                        style: {
                            background: "red",
                        }
                    }).showToast();
                })
            </script>
        @endif
    </body>
</html>
