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
			query:'',
			id:'',
			updateContact:'', 
			isEditing: false
		};
	}
	componentDidMount() {
		this._getContacts()
	}
	handleUpdate (contact) {
		//const allContacts = this.state.allContacts.filter(r => r.id !== id)
		console.log("NAME "+contact.name);
		this.setState({updateContact:contact,isEditing: !this.state.isEditing});
		//alert("ZZ "+this.state.id);
	}
	makeUpdate (contact) {
		console.log("id..."+contact.id);
		const allContacts = this.state.allContacts.map(r => { 
		
			if (r.id !== contact.id) return r; 
			console.log("return id..."+contact.id);
			return contact; 
		})
		if(this.state.displayedContacts.length>0){
			console.log("DISPLAYED... YES");
			const displayedContacts = this.state.displayedContacts.map(r => { 
			if (r.id !== contact.id) return r; 
			return contact; 
		})
		}else{
			var displayedContacts ='';
		}
console.log("set state... YES");
		this.setState({allContacts:allContacts,displayedContacts: displayedContacts});
	}
	handleDelete (ide) {
		//const allContacts = this.state.allContacts.filter(r => r.id !== id)
		
		this.setState({id:ide});
		//alert("ZZ "+this.state.id);
	}
	makeDelete (id) {
		const allContacts = this.state.allContacts.filter(r => r.id !== id)
		if(this.state.displayedContacts.length>0){
		const displayedContacts = this.state.displayedContacts.filter(r => r.id !== id)
		}else{
			var displayedContacts ='';
		}
		this.setState({allContacts:allContacts,id:id,displayedContacts: displayedContacts});
	}
	handleSearch(event) {
    var searchQuery = event.target.value.toLowerCase();
	 //var options = $('.select-search-options').val();
	 //alert(options[0]);
	// return false;
  var value = [];
 
	//alert("searh-options"+searchOptions[1]);

	//return false;
	$(".no-results").addClass('hide').html("");
	if(searchQuery!==""){
		var displayedContacts = this.state.allContacts.filter(function(el) {
		  var searchName = el.name.toLowerCase();
		  var searchAddress = el.address.toLowerCase();
		  var searchCompany = el.company.toLowerCase();
		  var searchEmail = el.email.toLowerCase();
		  var searchPhone = el.phone.toLowerCase();
		  var searchNickname = el.nick_name.toLowerCase();
		  var searchBirthdate = el.birth_date.toLowerCase();
		  var searchGender = el.gender.toLowerCase();
		  
		  //var result=searchValue.indexOf(searchQuery) !== -1;
			
			var filteredResults=searchName.indexOf(searchQuery) !== -1 || searchAddress.indexOf(searchQuery) !== -1 ||
			 searchCompany.indexOf(searchQuery) !== -1 || searchEmail.indexOf(searchQuery) !== -1 || searchPhone.indexOf(searchQuery) !== -1 ||
			searchNickname.indexOf(searchQuery) !== -1 || searchBirthdate.indexOf(searchQuery) !== -1  || searchGender.indexOf(searchQuery) !== -1;
			// alert("result:   "+result); 
			 // return false;
		  return filteredResults;
			
		});
		if(displayedContacts.length<=0){
				//alert("okkk");
				$(".no-results").removeClass('hide').html("No results !!");
		
			
		} 
		this.setState({
			  displayedContacts: displayedContacts
			});
	} else{
		this.setState({
		  displayedContacts: ''
		});
	}
	
    
  }
	_getContacts(queryText='') {
		 console.log("query text "+queryText);
		$(".no-results").addClass('hide').html("");
		//console.log(this.state.vale);
		var data="";
		//var data= search: (this.state.value!=='')?  this.state.value:'';
		
		$.get('/contacts/list',{ query: queryText},function(data) {
			this.setState({  query:queryText,allContacts: data });
			//alert("sdfffg"+data);
			if(jQuery.isEmptyObject(data)){
				//alert("okkk");
				$(".no-results").removeClass('hide').html("No results !!");
			}
		}.bind(this));
	}
	render() {
		if(this.state.displayedContacts.length<=0){
			if($(".no-results").is(':visible') ){
				var printContacts='';
		}else{
				var handleContacts = this.state.allContacts.map(function(contact) {
					return <ContactDisplay key={contact.id} id={contact.id} contact={contact}  handleUpdateRecord={this.handleUpdate} handleDeleteRecord={this.handleDelete} />
					
				},this); 
				var printContacts=handleContacts;
		}
		}else{
			 
			var handleFilteredContacts = this.state.displayedContacts.map(function(contact) {
				
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
			<hr className="divide"/>
			<div className="alert alert-info no-results hide"></div> 
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
	ReactDOM.render(
		<Contact />,
		document.getElementById('contact-list')
	);
}
   