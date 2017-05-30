<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	
	{{-- React related files --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Contacts Managment') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
						@if (Auth::guest())
                            <li><a  class="{!! route('login')==url()->current() || url()->current()==url()->to('/')  ? 'actual': '' !!} " href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <li><a class="{!! route('register')==url()->current()  ? 'actual': '' !!}" href="{{ route('register') }}"> Sign Up</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="user-name dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user"></span> {{ (Auth::user()->name)? Auth::user()->name : Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <ul id="user-admin" class="dropdown-menu" role="menu">
                                    <li>
                                        <a class="glyphicon glyphicon-log-out" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@if(Session::has('notification'))
					<div class="alert alert-danger"> 
					{{ Session::get('notification')}}
					</div>
				@endif
			</div>
		</div>
        @yield('content')
		
		<footer class="page-footer blue center-on-small-only">
		 <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2015 Copyright: <a href="https://www.MDBootstrap.com"> MDBootstrap.com </a>

        </div>
    </div>
    <!--/.Copyright-->
		</footer>
    </div>
	<script type="text/javascript">
		var csrf_token = '<?php echo csrf_token(); ?>'; 
    </script> 
    <!-- Scripts -->
    <script  src="{{ asset('js/app.js') }}"></script>
</body>
</html>
