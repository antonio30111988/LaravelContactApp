import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact search component
class ContactAudit extends Component {
	 constructor(props, context) {
		super(props, context);
		this.state = {
		  modified:this.props.modified,
		}
	}
	render() { 
		var handleAudit="";
		var handleAudit = [];

for (var item in this.state.modified) { 
    handleAudit.push(<tr key={this.props.id+"i"}>
						<td><strong>{item}</strong></td>
						<td className="danger">{item.old}</td>
						<td className="success">{item.new}</td>
					</tr>); 
}	
				
	  return (
			<div className="audit-item" id={ "item-"+this.props.metadata.audit_id} >
				<p>On {this.props.date} you  updated this record via {this.props.metadata.audit_url}: </p>
			
				<table className="table table-striped">
					<thead>
						<tr>
							<th>Attribute</th>
							<th>Old data</th>
							<th>New data</th>
						</tr>
					</thead>
					<tbody>
						{handleAudit}						
					 </tbody>
				</table>				 
			</div>
	  );
	}
}

export default ContactAudit;