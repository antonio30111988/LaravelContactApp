import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import ContactHeader from './components/contact-header';
import ContactDisplay from './components/contact-display';
import ContactPoster from './components/contact-poster';
import ContactDelete from './components/contact-delete';
import ContactUpdate from './components/contact-update';
import ContactAudits from './components/contact-audits';

//main app component
class Contact extends Component {
	constructor(props) {
		super(props);
		this.handleUpdate=this.handleUpdate.bind(this),
		this.handleDelete=this.handleDelete.bind(this),
		this.makeDelete=this.makeDelete.bind(this),
		this.makeUpdate=this.makeUpdate.bind(this),
		this._getContacts=this._getContacts.bind(this),
		this.state = {
			allContacts: [],
			displayedContacts: [],
			id:'',
			updateContact:{}, 
		};
	}
	componentDidMount() {
		//retrive all contacts by initial mount
		this._getContacts()
	}
	handleUpdate (contact) {
		//set state to current edited contact object
		this.setState(
		{
			updateContact:contact
		});
	}
	makeUpdate () {
		this._getContacts();
	}
	handleDelete (id) {		
		//set state id to clicked contactt for deletion
		this.setState(
		{
			id:id
		});
	}
	makeDelete (id) {
		const allContacts = this.state.allContacts.filter(r => r.id !== id)
		
		//if currently searching
		if(this.state.displayedContacts.length>0){
			//update searched contact list
			const displayedContacts = this.state.displayedContacts.filter(r => r.id !== id)
		}else{
			var displayedContacts ='';
		}
		
		//updating states
		this.setState({
			allContacts:allContacts,
			id:id,
			displayedContacts: displayedContacts
		});
	}
	handleSearch(event) {
		var searchQuery = event.target.value.toLowerCase();
		var value = [];
		$(".no-results").addClass('hide').html("");
		
		//if searching
		if(searchQuery!==""){
			var displayedContacts = this.state.allContacts.filter(function(el) {
				//make no diff bewteeen lowercase and uppercase
				var searchName = el.name.toLowerCase();
				var searchAddress = el.address.toLowerCase();
				var searchCompany = el.company.toLowerCase();
				var searchEmail = el.email.toLowerCase();
				var searchPhone = el.phone.toLowerCase();
				var searchNickname = el.nick_name.toLowerCase();
				var searchBirthdate = el.birth_date.toLowerCase();
				var searchGender = el.gender.toLowerCase();

				//filter by all content inside contact item
				var filteredResults=searchName.indexOf(searchQuery) !== -1 || searchAddress.indexOf(searchQuery) !== -1 ||
				searchCompany.indexOf(searchQuery) !== -1 || searchEmail.indexOf(searchQuery) !== -1 || searchPhone.indexOf(searchQuery) !== -1 ||
				searchNickname.indexOf(searchQuery) !== -1 || searchBirthdate.indexOf(searchQuery) !== -1  || searchGender.indexOf(searchQuery) !== -1;
				
				return filteredResults;
			});
			
			//no results display No results
			if(displayedContacts.length<=0){
					$(".no-results").removeClass('hide').html("No results !!");	
			} 
			this.setState({
				displayedContacts: displayedContacts
			});
		} else{
			//reset search content
			this.setState({
				displayedContacts: ''
			});
		}
	}
	_getContacts() {
		$(".no-results").addClass('hide').html("");
		var data="";
		
		//get ajax request fetch all contacts
		$.get('/contacts/list',{ },function(data) {
			//update state
			this.setState({ 
				allContacts: data 
			});
			
			//if no results display message
			if(jQuery.isEmptyObject(data)){
				$(".no-results").removeClass('hide').html("No results !!");
			}
		}.bind(this)); 
	}
	render(){
		if(this.state.displayedContacts.length<=0){
			//if already no results
			if($(".no-results").is(':visible') ){
				var printContacts='';
			}else{
				//if not fetch all contacts data
				var handleContacts = this.state.allContacts.map(function(contact) {
					return <ContactDisplay key={contact.id} id={contact.id} contact={contact}  handleUpdateRecord={this.handleUpdate} handleDeleteRecord={this.handleDelete} />	
				},this); 
				var printContacts=handleContacts;
			}
		}else{
			//get all filtered by search pattern data
			var handleFilteredContacts = this.state.displayedContacts.map(function(contact) 
			{
				return <ContactDisplay key={contact.id} id={contact.id} contact={contact}  handleUpdateRecord={this.handleUpdate} handleDeleteRecord={this.handleDelete} />
			},this);
			var printContacts=handleFilteredContacts;
		}
		
		return (
			<div>
				<ContactHeader />
				<ContactPoster refreshContacts={this._getContacts} />
				<div className="searchable collapse" id="search-contacts-area" data-scroll-offset="70" >
					<h2 className="search-contacts create-contact"> Search Contacts: </h2>
					<input type="text" placeholder="by any content" className="contact-input search-field" onChange={this.handleSearch.bind(this)}/>
					<div className="alert alert-info no-results hide"></div> 
					<hr className="divide"/>
				</div>
				<ContactAudits /> 
				<ContactDelete  id={this.state.id} deleteContacts={this.makeDelete} />
				<ContactUpdate  contact={this.state.updateContact} updateContacts={this.makeUpdate} />
				{printContacts} 
			</div>
		);
	}
}

export default  Contact;

if (document.getElementById('contact-list')) {
	//render app
	ReactDOM.render
	(
		<Contact />,
		document.getElementById('contact-list')
	);
}
   