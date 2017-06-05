import React, { Component } from 'react';

//Contact audit row component
class ContactAudit extends Component {
	constructor(props, context) {
		super(props, context);
		this.state = {
			modified:this.props.modified,
		}
	}
	render() { 
		var handleAudit = [];
		var counter=0;
		//get modified data to table row in arary
		for (var item in this.state.modified) { 
			if (!this.state.modified.hasOwnProperty(item)) continue;
			var values=[];
			var obj=this.state.modified[item];
			for (var i in obj) {
				 if(!obj.hasOwnProperty(i)) continue;
				values.push(obj[i]);
			}
			
			handleAudit.push(
				<tr key={counter}>
					<td><strong>{item}</strong></td>
					<td className="danger">{values[0]}</td>
					<td className="success">{values[1]}</td>
				</tr>
			); 
			
			counter++;
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