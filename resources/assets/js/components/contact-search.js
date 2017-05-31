import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact search component
class ContactSearch extends Component {
	constructor(props) {
	   super(props);
	  // this.doSearch = debounce(this.doSearch,1000);
	}
	componentWillMount() {
       //this.doSearch = debounce(this.doSearch,1000); 
    }
	doSearch(){
		
		var query=this.refs.search.value; 
		alert(query);
		this.props.doSearch(query);
		
    }
	render() {
	  return (
		  <div className="searchable">
			<h2 className="search-contacts"> Search Contacts </h2>
			<input className="contact-input" type="text" ref="search" placeholder="Default (by name)" value={this.props.query} onChange={this.doSearch.bind(this)}   />
			
			<select className="contact-input select-search-options js-states "  ref="search-options" multiple="" tabIndex="-1" aria-hidden="true" >
				<option value="name">Name</option> 
				<option value="birth_date">Birth date</option>
				<option value="phone">Phone</option>
				<option value="email">Email</option>
				<option value="address">Address</option>
				<option value="company">Company</option>
				<option value="nick_name">Company</option>
				<option value="gender">Gender</option>
			</select>
			<hr className="divide"/>
			<div className="alert alert-info no-results hide"></div> 
		  </div>
	  );
	} 
}

export default ContactSearch;