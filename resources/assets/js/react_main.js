import React from 'react';
import ReactDOM from 'react-dom';
 
import ContactHeader from './components/contact-header.js';
import ContactDisplay from './components/contact-display.js';
import ContactPoster from './components/contact-poster.js';


//main app component
export default class Contact extends React.Component{
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
}

if (document.getElementById('content')) {
	//render app
	ReactDOM.render(
		<Contact />,
		document.getElementById('content')
	);
}
   