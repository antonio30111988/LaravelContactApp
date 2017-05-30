import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact search component
class ContactSearch extends Component {
	doSearch(){
		var query=this.refs.search.value; 
		this.props.doSearch(query);
    }
	render() {
	  return (
		<input className="contact-input" type="text" ref="search" placeholder="Search Contacts" value={this.props.query} onChange={this.doSearch.bind(this)}  />
	  );
	}
}

export default ContactSearch;