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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.0/react.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.0/react-dom.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	{{--<script type="text/babel" src="js/main.js"></script>--}}

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
                            <li><a  class="{!! route('login')==url()->current() || url()->current()==url()->to('/')  ? 'actual': '' !!}" href="{{ route('login') }}">Login</a></li>
                            <li><a class="{!! route('register')==url()->current()  ? 'actual': '' !!}" href="{{ route('register') }}">Sign Up</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
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

        @yield('content')
    </div>
	@if( route('home')==url()->current()  ) 
	<script type="text/babel">
		//main app component
var Contact = React.createClass({
	getInitialState: function() {
		return {
			allContacts: [],
		};
	},
	componentDidMount: function() {
		
	},
	_getContacts: function() {
		$.get('/contacts/list',function(data) {
			this.setState({ allContacts: data });
		}.bind(this));
	},
	render: function() {
		var handleContacts = this.state.allContacts.map(function(contact) {
			return <ContactDisplay key={contact.id} id={contact.id} contact={contact.contact} />
		});
		return (
			<div>
			  <ContactHeader />
			  <ContactPoster />
			  {this._getContacts()}
			  {handleContacts}
			</div>
		);
	}
});

//Contact header component
var ContactHeader = React.createClass({
	render: function() {
	  return (
		<h2> Contact List: </h2>
	  );
	}
});
//Contact post component
var ContactPoster = React.createClass({
	_handleClick: function() {
		var contactValue = this.refs.contactvalue.value;
		console.log(contactValue);
		$.post('/contacts/create', { contact: contactValue }, function(data) {
			console.log(data);
		});
	},
	render: function() {
	  return (
		<div>
			<input type="text" placeholder="Creat new contact ..." ref="contactvalue" />
			<input type="button" value="Create" onClick={this._handleClick} />
		</div>
	  );
	}
});

//Contact display list component
var ContactDisplay = React.createClass({
	getInitialState: function() {
		return {
			editinput: false
		};
	},
	_removeItem: function() {
		console.log(this.props.id);
		$.post('/contacts/delete',{ id: this.props.id }, function(data) {
			console.log(data);
		});
	},
	_editItem: function() {
		this.state.editinput ? this.setState({ editinput: false }) : this.setState({ editinput: true });
	},
	_handleSubmit: function() {
		var editedValue = this.refs.editContactValue.value;
		$.post('/contacts/edit', { id: this.props.id, tweet: editedValue },function() {
			this.setState({ editinput: false });
		}.bind(this));
	},
	render: function() {
		return(
			<div>
				Contact by Swagger :
				{this.props.contact}
				{this.state.editinput ? <div> <input type="text"  placeholder="Edit Contact..." ref="editContactValue" /> <button onClick={this._handleSubmit} > Done </button> </div>: '' }
				<button onClick={this._editItem} > Edit </button>
				<button onClick={this._removeItem} > Remove </button>
			</div> 
		);
	}
});

//render app
ReactDOM.render(
	<Contact />,
	document.getElementById('contact-list')
);
	</script>
@endif
    <!-- Scripts -->
    <script  src="{{ asset('js/app.js') }}"></script>
</body>
</html>
