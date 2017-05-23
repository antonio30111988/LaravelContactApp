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
	document.getElementById('content')
);