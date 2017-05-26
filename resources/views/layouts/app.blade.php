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
                            <li><a class="{!! route('register')==url()->current()  ? 'actual': '' !!}" href="{{ route('register') }}"> SIGN UP</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="user-name dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} <span class="caret"></span>
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

        @yield('content')
    </div>
	<script type="text/babel">
		//main app component
var Contact = React.createClass({
	getInitialState: function() {
		return {
			allContacts: [],
			query:'',
		};
	},
	componentDidMount: function() {
		this._getContacts();
	},
	_getContacts: function(queryText='') {
		 console.log("query text "+queryText);
		
		console.log(this.state.vale);
		var data="";
		//var data= search: (this.state.value!=='')?  this.state.value:'';
		
		$.get('/contacts/list',{ query: queryText},function(data) {
			this.setState({  query:queryText,allContacts: data });
		}.bind(this));
	},
	render: function() {
		var handleContacts = this.state.allContacts.map(function(contact) {
			return <ContactDisplay key={contact.id} id={contact.id} contact={contact} refreshContacts={this._getContacts} />
		});
		return (
			<div>
				
			  <ContactHeader />
			  <ContactPoster refreshContacts={this._getContacts} /> 
			  <ContactSearch query={this.state.query} doSearch={this._getContacts} />
			 
			  {handleContacts}
			</div>
		);
	}
});

//Contact header component
var ContactHeader = React.createClass({
	render: function() {
	  return (
		<h2 className="create-contact"> Create new contact: </h2>
	  );
	}
});

//Contact search component
var ContactSearch = React.createClass({
	 doSearch:function(){
        var query=this.refs.search.getDOMNode().value; 
        this.props.doSearch(query);
    },
	render: function() {
	  return (
	  
		<input className="contact-input" type="text" ref="search" placeholder="Search Contacts" value={this.props.query} onChange={this.doSearch}  />

	  );
	}
});

//Contact post component
var ContactPoster = React.createClass({
	_refreshContacts:function(){
        this.props.refreshContacts();
    },
	_handleClick: function() {
		
		$("#validation_errors").html("");

		var name = this.refs.name.value;
		var nick_name = this.refs.nickname.value;
		var birth_date = this.refs.birth_date.value;
		var email = this.refs.email.value;
		var phone = this.refs.phone.value;
		var address = this.refs.address.value;
		var company = this.refs.company.value;
		var gender = this.refs.gender.value;
	
		console.log(name);
		console.log(nick_name);
		console.log(birth_date);
		console.log(email);
		console.log(phone);
		console.log(address);
		console.log(company);
		console.log(gender);
		
		$.post('/contacts/create', 
		{ 
			_token: csrf_token,
			name: name, 
			nick_name: nick_name, 
			company: company, 
			email: email, 
			phone: phone, 
			address: address, 
			gender: gender, 
			birth_date: birth_date, 
			
		}, function(data) {
			console.log(data);
			this._refreshContacts();
		}).fail(function(xhr, status, error) {
       
			//alert(error);
			//alert(status);
			//alert(xhr);
			alert(xhr.responseText);
			
			if(xhr.status==422)
			{
				var jso=jQuery.parseJSON(xhr.responseText);
				//alert(jso.email);
			
				jQuery.each(jso, function(i, val) {
					jQuery.each(val, function() {
						$("#validation_errors").append("<li>"+this+"</li>");
					});
					//$("#validation_errors").append("<li>"+val+"</li>");
				});
			}	
		});
	},
	render: function() {
	  return (
		<div className="create-contact-area">
			<input className="contact-input" type="text" placeholder="Name" ref="name" required />
			<input className="contact-input" type="text" placeholder="Nickname" ref="nickname" />
			<input className="contact-input" type="email" placeholder="Email" ref="email" required />
			<input className="contact-input" type="email" placeholder="Phone (01...)" ref="phone" required />
			<input className="contact-input" type="text" placeholder="Adress" ref="address" required />
			<input className="contact-input" type="text" placeholder="Company" ref="company" required />
			<input className="contact-input" type="date" id="birth_date"  placeholder="Birth date" ref="birth_date" />
			<select className="contact-input select-gender" ref="gender">
				<option value="0">Choose gender</option>
				<option value="1">Male</option>
				<option value="2">Female</option>
			</select>
			<input className="create-contact btn btn-primary" type="button" value="Create" onClick={this._handleClick} />
			
			<ul className="validation_errors" id="validation_errors"></ul>
			<hr className="divide"/>
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
	_refreshContacts:function(){
        this.props.refreshContacts();
    },
	_removeItem: function() {
		$("#show-modal").modal();	
		$("#modal-save").attr('data-delete',this.props.id);	
	},
	_editItem: function() {
		alert("DARTE:"+this.props.contact.birth);
		this.state.editinput ? this.setState({ editinput: false }) : this.setState({ editinput: true });
	},
	_handleSubmit: function() {
		$("#validation_errors"+this.props.id).html("");

		var id=this.props.id;
		var edited_name = this.refs.edit_name.value;
		//alert("edited name "+edited_name);
		//return false;
		var edited_nick_name = this.refs.edit_nickname.value;
		var edited_birth_date = this.refs.edit_birth_date.value;
		var edited_email = this.refs.edit_email.value;
		var edited_phone = this.refs.edit_phone.value;
		var edited_address = this.refs.edit_address.value;
		var edited_company = this.refs.edit_company.value;
		var edited_gender = this.refs.edit_gender.value;
		
		console.log(edited_name);
		console.log(edited_nick_name);
		console.log(edited_birth_date);
		console.log(edited_email);
		console.log(edited_phone);
		console.log(edited_address);
		console.log(edited_company);
		console.log(edited_gender); 
		//alert("	token"+csrf_token);
		//return false;
		
		$.post('/contacts/update', { 
			_token: csrf_token,
			id: this.props.id,
			name: edited_name, 
			nick_name: edited_nick_name, 
			company: edited_company, 
			email: edited_email, 
			phone: edited_phone, 
			address: edited_address, 
			gender: edited_gender, 
			birth_date: edited_birth_date, 
		},function() {
			this.setState({ editinput: false });
			this._refreshContacts();
		}.bind(this)).fail(function(xhr, status, error) {
       
			//alert(error);
			//alert(status);
			//alert(xhr);
			alert(xhr.responseText);
			alert("CODE "+xhr.status);
			
			if(xhr.status==422)
			{
				var jso=jQuery.parseJSON(xhr.responseText);
				//alert(jso.email);
				
				jQuery.each(jso, function(i, val) {
					jQuery.each(val, function() {
						$("#validation_errors"+id).append("<li>"+this+"</li>");
						//alert(id);
					});
				});
			}
			
		});
	},
	_handleNameChange: function() {
		this.setState({ [event.target.ref]: event.target.value });
	 },
	render: function() {
		return(
			<div className="contact-item" id={this.props.contact.id}>
				
				<span className="do-delete glyphicon glyphicon-remove" onClick={this._removeItem}  ></span>
			
				<div className=" contact contact-main">
					<h3 className=" contact " ><span className="contact-labels glyphicon glyphicon-user"></span>  {!this.state.editinput ? <span className="contact-name">{this.props.contact.name}</span>: <input type="text" id="editName"  ref="edit_name" onChange={this._handleNameChange} defaultValue={this.props.contact.name}  placeholder="Name"   />  }  {!this.state.editinput ? <span className="contact-birth-date">{ (this.props.contact.age>0)? this.props.contact.age+'yrs':''} </span>: <input type="date" id="editBirthDate" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.birth}  placeholder="Birth Date" ref="edit_birth_date"  />  }</h3>	
				</div>
				<div className=" contact contact-info">
				<h4 className="contact contact-phone"><span className="contact-labels glyphicon glyphicon-phone-alt"></span> {!this.state.editinput ? <span className="contact-content">{this.props.contact.phone}</span>: <input type="text" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.phone}  placeholder="Name" ref="edit_phone"  />  }</h4> 					

				<h4 className=" contact contact-email"><span className="contact-labels glyphicon glyphicon-envelope"></span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.email}</span>: <input type="email" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.email}  placeholder="Email" ref="edit_email"  />  }</h4>
				<h4 className=" contact contact-address"><span className="contact-labels glyphicon glyphicon-map-marker"></span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.address}</span>: <input type="text" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.address}  placeholder="Adress" ref="edit_address"  />  }</h4>
				<h4 className=" contact contact-company"><span className="contact-labels glyphicon glyphicon-tower"></span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.company}</span>: <input type="text" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.company}  placeholder="Company" ref="edit_company"  />  }</h4>
				</div>
				<div className=" contact contact-additional">
					<p className=" contact contact-gender"><span className="contact-labels">Sex:</span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.gender}</span>: 
					<select defaultValue={this.props.contact.gender_flag}  className="contact-input editInputs select-gender" onChange={this._handleNameChange} ref="edit_gender" >
				<option  value="0">Choose gender</option>
				<option  value="1">Male</option>
				<option   value="2">Female</option>
			</select>  }</p>
					<p className=" contact contact-nickname"><span className="contact-labels">Nickname:</span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.nick_name}</span>: <input type="text" id="nickname_input" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.nick_name}  placeholder="Nickname" ref="edit_nickname"  />  }</p>
				</div>
				
				<div className="do-edit-save">
				{this.state.editinput ?	
					<button onClick={this._handleSubmit} className="do-save btn btn-success btn-sm" > Save </button>
					

				: '' }
				<button  onClick={this._editItem} className="do-edit btn btn-danger btn-sm">
					<span className="  glyphicon glyphicon-edit"></span> Edit
				</button>
				</div>
				<ul className="validation_errors" id={"validation_errors"+this.props.id} ref="validation"></ul>
			
				
			</div> 
			
		);
	}
});

ReactDOM.render(
	<Contact />,
	document.getElementById('contact-list')
);
</script>	
	<script type="text/javascript">
		var csrf_token = '<?php echo csrf_token(); ?>'; 
    </script>
    <!-- Scripts -->
    <script  src="{{ asset('js/app.js') }}"></script>

	
	<div class="modal fade" tabindex="-1" role="dialog" id="show-modal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Edit post</h4>
	      </div>
	      <div class="modal-body">
	        Are you sure you want to delete contact?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	        <button type="button" class="btn btn-primary" data-delete="" id="modal-save">Yes</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>
