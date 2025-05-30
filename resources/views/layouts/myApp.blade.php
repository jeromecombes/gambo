<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>VWPP Database</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}?rev=20210330" rel="stylesheet">
        <link href="{{ asset('js/DataTables/datatables.min.css') }}?rev=20250530" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}?rev=20250530" rel="stylesheet">
        <link href="{{ asset('css/print.css') }}?rev=20210330" rel="stylesheet" media="print">

        <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon">

        <script src="{{ asset('js/DataTables/datatables.min.js') }}?rev=20250530"></script>
        <script src="{{ asset('js/DataTables/sort.js') }}?rev=20250530"></script>
        <script src="{{ asset('js/CJScript.js') }}?rev=20250530"></script>
        <script src="{{ asset('js/script.js') }}?rev=20210414"></script>
    </head>

    <body>

        <div id='body'>
            <div class="content">
                <div id='title'>
                    @if(!Auth::user()->admin)
                        VWPP Database
                    @elseif(!session('student'))
                        VWPP Database - Admin
                    @else
                        VWPP Database - {{ session('student_name') }}
                    @endif
                </div>
                <div id='loginName'>
                    <span>{{ Auth::user()->display_name }}</span>
                    <span class='ui-icon ui-icon-triangle-1-s' id='myMenuTriangle'></span><br/>
                    <div id='myMenu'>
                        <a href="{{ route('account.index') }}">My Account</a><br/>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div class='ui-tabs ui-widget ui-widget-content ui-corner-all'>

                    @if(Auth::user()->admin)
                        @if(session('student'))
                            @include('layouts.menu_admin_student')
                        @else
                            @include('layouts.menu_admin')
                        @endif
                    @else
                        @include('layouts.menu_student')
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success"> {{ session('success') }}</div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning"> {{ session('warning') }}</div>
                    @endif

                    <section id='content'>
                        @yield('content')
                    </section> <!-- content -->

                </div>	<!-- tabs -->
            </div>
            <footer>
                <a href='http://www.jeromecombes.com' target='_blank'>Created by jeromecombes.com</a>
            </footer>
        </div> <!-- id=body or login1-->
    </body>
</html>
