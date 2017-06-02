import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact header component
class ContactHeader extends Component {
	render() {
	  return (
		<div className="features-area row">
			 <button type="button" className="col-md-3 col-sm-6 btn btn-add btn-info scrollto" data-toggle="collapse" data-target="#search-contacts-area" data-attr-scroll="#search-contacts-area">Search Contacts</button>
			 <button type="button" className="col-md-3 col-sm-6 btn btn-add btn-success scrollto" data-toggle="collapse" data-target="#create-contact-area" data-attr-scroll="#create-contact-area" >Add Contact</button>
			<button type="button" className="col-md-3 col-sm-6 btn btn-add btn-danger scrollto" data-toggle="collapse" data-target="#contact-audits-area" data-attr-scroll="#contact-audits-area" >View App Audit</button>

			<button type="button" className="col-md-3 col-sm-6 btn btn-warning" >Export to VD Card</button>
	
		</div>
	  );
	}
}

export default ContactHeader;