import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import ContactHeader from './components/contact-header';
import ContactDisplay from './components/contact-display';
import ContactPoster from './components/contact-poster';
import ContactDelete from './components/contact-delete';
import ContactUpdate from './components/contact-update';
import ContactSearch from './components/contact-search';

//main app component
class Contact extends Component {
//export default class Contact extends React.Component{
	/*getInitialState() {
		return {
			allContacts: [],
		};
	}*/
	constructor(props) {
		super(props);
		this.handleUpdate=this.handleUpdate.bind(this),
		this.handleDelete=this.handleDelete.bind(this),
		this.makeDelete=this.makeDelete.bind(this),
		this.makeUpdate=this.makeUpdate.bind(this),
		this._getContacts=this._getContacts.bind(this),
		this.state = {
			allContacts: [],
			query:'',
			id:'',
			updateContact:'',
		};
	}
	componentDidMount() {
		this._getContacts()
	}
	handleUpdate (contact) {
		//const allContacts = this.state.allContacts.filter(r => r.id !== id)
		
		this.setState({updateContact:contact});
		//alert("ZZ "+this.state.id);
	}
	makeUpdate (contact) {
		const allContacts = this.state.allContacts.map(r => { 
			if (r.id !== contact.id) return r; 
			return contact; 
		})

		this.setState({allContacts:allContacts});
	}
	handleDelete (ide) {
		//const allContacts = this.state.allContacts.filter(r => r.id !== id)
		
		this.setState({id:ide});
		//alert("ZZ "+this.state.id);
	}
	makeDelete (id) {
		const allContacts = this.state.allContacts.filter(r => r.id !== id)

		this.setState({allContacts:allContacts,id:id});
	}
	_getContacts(queryText='') {
		 console.log("query text "+queryText);
		
		//console.log(this.state.vale);
		var data="";
		//var data= search: (this.state.value!=='')?  this.state.value:'';
		
		$.get('/contacts/list',{ query: queryText},function(data) {
			this.setState({  query:queryText,allContacts: data });
		}.bind(this));
	}
	render() {
		var handleContacts = this.state.allContacts.map(function(contact) {
			return <ContactDisplay key={contact.id} id={contact.id} contact={contact}  handleUpdateRecord={this.handleUpdate} handleDeleteRecord={this.handleDelete} />
		},this); 
		return (
			<div>
			  <ContactHeader />
			  <ContactPoster refreshContacts={this._getContacts} />
			  <ContactSearch query={this.state.query} doSearch={this._getContacts} />
			<ContactDelete  id={this.state.id} deleteContacts={this.makeDelete} />
			<ContactUpdate  contact={this.state.updateContact} updateContacts={this.makeUpdate} />

			  {handleContacts} 
			</div>
		);
	}
}

export default  Contact;

if (document.getElementById('contact-list')) {
	//render app
	ReactDOM.render(
		<Contact />,
		document.getElementById('contact-list')
	);
}
   