<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-grid.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-reboot.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/fontawesome/css/font-awesome.min.css')}}">
        <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <link href="{{asset('select2/dist/css/select2.min.css')}}" rel="stylesheet" />
        <script src="{{asset('select2/dist/js/select2.min.js')}}"></script>
        <script src="{{asset('Auto-Format-Currency-With-jQuery/simple.money.format.js')}}"></script>
        
        <title>Kasir Tumas</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: Tahoma, Geneva, sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        @yield('content')
        @yield('script')
    </body>
</html>