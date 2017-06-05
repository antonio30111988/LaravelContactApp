import React, { Component } from 'react';

//Contacts display in list component
class ContactDisplay extends Component {
	handleUpdateRecord(contact) { 
		this.props.handleUpdateRecord(contact);
	}
	handleDeleteRecord(id) {
		this.props.handleDeleteRecord(id);
	}
	_removeItem() {
		$("#show-modal").modal();	
		this.handleDeleteRecord(this.props.id);
	}
	_editItem() {
		$("#show-modal-update").modal();	
		//console.log("print name "+this.props.contact.name);
		this.handleUpdateRecord(this.props.contact);
	}
	render() {
		return(
			<div className="contact-item" >
				<span className="do-delete glyphicon glyphicon-remove" onClick={this._removeItem.bind(this)}  ></span>
			
				<div className=" contact contact-main">
					<h3 className=" contact " ><span className="contact-labels glyphicon glyphicon-user"></span>  <span className="contact-name">{this.props.contact.name}</span> <span className="contact-birth-date">{ (this.props.contact.age>0)? this.props.contact.age+'yrs':''} </span></h3>	
				</div>
				
				<div className=" contact contact-info">
					<h4 className="contact contact-phone"><span className="contact-labels glyphicon glyphicon-phone-alt"></span> <span className="contact-content">{this.props.contact.phone}</span></h4> 				
					<h4 className=" contact contact-email"><span className="contact-labels glyphicon glyphicon-envelope"></span>  <span className="contact-content">{this.props.contact.email}</span></h4>
					<h4 className=" contact contact-address"><span className="contact-labels glyphicon glyphicon-map-marker"></span>  <span className="contact-content">{this.props.contact.address}</span></h4>
					<h4 className=" contact contact-company"><span className="contact-labels glyphicon glyphicon-tower"></span> <span className="contact-content">{this.props.contact.company}</span></h4>
				</div>
				
				<div className=" contact contact-additional">
					<p className=" contact contact-gender">
						<span className="contact-labels addit-title">Sex:</span>   
						<span className="contact-content">{this.props.contact.gender}</span>
					</p>
					<p className=" contact contact-nickname">
						<span className="contact-labels addit-title">Nickname:</span>  
						<span className="contact-content">{this.props.contact.nick_name}</span>
					</p>
				</div>
				
				<div className="do-edit-save">
					<button className="do-save export btn btn-warning btn-sm  " id={this.props.id} data-id={this.props.id}><span className="glyphicon glyphicon-download"></span> to vCard </button>
					<button  onClick={this._editItem.bind(this)} className="do-edit btn btn-edit btn-sm">
						<span className="  glyphicon glyphicon-edit"></span> Edit
					</button>
				</div>
				
				<ul className="validation_errors" id={"validation_errors"+this.props.id} ref="validation"></ul>
			</div> 
		);
	} 
}

export default ContactDisplay;
