import React, { Component } from 'react';
import ContactAudit from './contact-audit'; 

//User contacts audits/history log main component
class ContactAudits extends Component {
	constructor(props, context) {
		super(props, context);
		this.getAuditsMetadata=this.getAuditsMetadata.bind(this),
		this.state = 
		{
			audits:[],
		}
	}
	componentDidMount() {
		this.getAuditsMetadata()
	}
	getAuditsMetadata(event){
		$(".no-results-audits").addClass('hide').html("");
		
		//ajax request fetch audits data
		$.get('/contacts/audits',{},function(data) {
			this.setState({ audits: data });
			if(jQuery.isEmptyObject(data)){
				//alert("okkk");
				$(".no-results-audits").removeClass('hide').html("No results !!");
			}
		}.bind(this));
    }
	render() {
		var handleAudits = this.state.audits.map(function(audit) 
		{
			return <ContactAudit key={audit.metadata.audit_id} id={audit.metadata.audit_id} date={audit.created_at_formatted} modified={audit.modified} metadata={audit.metadata}  />	
		},this); 
	
	
		return (
			<div className="contact-audits-area collapse" id="contact-audits-area" data-scroll-offset="100">
				{handleAudits}
				<span className="alert alert-info no-results-audits hide"></span> 
				<hr className="divide"/>
			</div>
		);
	}
}

export default ContactAudits;