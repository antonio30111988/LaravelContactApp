import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact search component
class ContactUpdate extends Component {
	 updateContacts(){
		 
        /*var id=this.props.contact.id;  
        alert(id+"  dsvd");
		$.post('/contacts/delete',{ id: id,_token: csrf_token }, function(data) {
			console.log("ovo je id"+id);
			 this.props.deleteContacts(id);
		}.bind(this)).done(function(msg){
			$("#show-modal").modal('hide');
		});*/
		var contact=this.props.contact;
		
		$("#validation_errors"+this.props.contact.id).html("");

		var id=this.props.contact.id;
		var edited_name = this.refs.edit_name.value;
		//alert("edited name "+edited_name);
		//return false;
		var edited_nick_name = this.refs.edit_nickname.value;
		var edited_birth_date = this.refs.edit_birth_date.value;
		var edited_email = this.refs.edit_email.value;
		var edited_phone = this.refs.edit_phone.value;
		var edited_address = this.refs.edit_address.value;
		var edited_company = this.refs.edit_company.value;
		var edited_gender = this.refs.edit_gender.value;
		
		console.log(edited_name);
		console.log(edited_nick_name);
		console.log(edited_birth_date);
		console.log(edited_email);
		console.log(edited_phone);
		console.log(edited_address);
		console.log(edited_company);
		console.log(edited_gender); 
		//alert("	token"+csrf_token);
		//return false;
		
		$.post('/contacts/update', { 
			_token: csrf_token,
			id: this.props.id,
			name: edited_name, 
			nick_name: edited_nick_name, 
			company: edited_company, 
			email: edited_email, 
			phone: edited_phone, 
			address: edited_address, 
			gender: edited_gender, 
			birth_date: edited_birth_date, 
		},function() {
			console.log("ovo je contact "+contact);
			 this.props.updateContacts(contact);
		}.bind(this)).fail(function(xhr, status, error) {
       
			//alert(error);
			//alert(status);
			//alert(xhr);
			//alert(xhr.responseText);
			//alert("CODE "+xhr.status);
			
			if(xhr.status==422)
			{
				var jso=jQuery.parseJSON(xhr.responseText);
				//alert(jso.email);
				
				jQuery.each(jso, function(i, val) {
					jQuery.each(val, function() {
						$("#validation_errors"+id).append("<li>"+this+"</li>");
						//alert(id);
					});
				});
			}
			
		});
    }
	_handleNameChange() {
		this.setState({ [event.target.ref]: event.target.value });
	 }
	render() {
	  return (
			<div className="modal fade" tabIndex="-1" role="dialog" id="show-modal-update">
			  <div className="modal-dialog" role="document">
				<div className="modal-content">
				  <div className="modal-header">
					<button type="button" className="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 className="modal-title">Edit contact</h4>
				  </div>
				  <div className="modal-body">
					<form>
					<div className="form-group">
					<label htmlFor="editName" className="control-form-label">Name</label>
					<div className="input-group">
					<div className="input-group-addon ">
					<span className="glyphicon glyphicon-user"></span>
					</div>

					<input className="form-control " type="text" id="editName" name="name" ref="edit_name" onChange={this._handleNameChange} defaultValue={this.props.contact.name}  />
					</div>
					</div>
					<div className="form-group ">
					<label htmlFor="editBirthDate" className="control-form-label">Birth date</label>
					<div className="input-group">
					<div className="input-group-addon ">
					<span className="glyphicon glyphicon-calendar"></span>
					</div>
					<input className="form-control" type="date" id="editBirthDate" name="editBirthDate" ref="edit_birth_date" onChange={this._handleNameChange} defaultValue={this.props.contact.birth_date} />
					</div>
					</div>
					<div className="form-group ">
					<label htmlFor="editPhone" className="control-form-label">Telephone</label>
					<div className="input-group">
					<div className="input-group-addon ">
					<span className="glyphicon glyphicon-phone-alt"></span>
					</div>
					<input className="form-control " type="tel" id="editPhone" name="editPhone"  ref="edit_phone" onChange={this._handleNameChange} defaultValue={this.props.contact.phone}/>
					</div>
					</div>
					<div className="form-group">
					<label htmlFor="editEmail" className="control-form-label">Email</label>
					<div className="input-group">
					<div className="input-group-addon ">
					<span className="glyphicon glyphicon-envelope"></span>
					</div>
					<input className="form-control" type="email" id="editEmail" name="editEmail" ref="edit_email" onChange={this._handleNameChange} defaultValue={this.props.contact.email} />
					</div>
					</div>
					<div className="form-group">
					<label htmlFor="editAddress" className="control-form-label">Adress</label>
					<div className="input-group">
					<div className="input-group-addon ">
					<span className="glyphicon glyphicon-map-marker"></span>
					</div>
					<input className="form-control" type="text" id="editAddress" name="editAddress" ref="edit_address" onChange={this._handleNameChange} defaultValue={this.props.contact.address} />
					</div>
					</div>
					<div className="form-group">
					<label htmlFor="editCompany" className="control-label">Company</label>
					<div className="input-group">
					<div className="input-group-addon ">
					<span className="glyphicon glyphicon-tower"></span>
					</div>
					<input className="form-control" type="text" id="editCompany" name="editCompany" ref="edit_company" onChange={this._handleNameChange} defaultValue={this.props.contact.company} />
					</div>
					</div>
					<div className="form-group">
					<label htmlFor="editGender" className="control-label">Gender</label>
					<select className="form-control form-control-md" defaultValue={this.props.contact.gender_flag} onChange={this._handleNameChange} ref="edit_gender" id="editGender" name="editGender">
					<option value="0">Choose--</option>
					<option value="1">Male</option>
					<option value="2">Female</option> 

					</select>
					</div>
					<div className="form-group ">
					<label htmlFor="editNickname" className="control-form-label">Nickname</label>
					<div className="col-10">
					<input className="form-control form-control-md" type="text" id="editNickname" name="editNickname" ref="edit_nickname" onChange={this._handleNameChange} defaultValue={this.props.contact.nick_name} />
					</div>
					</div>
					</form>
					/*Valdation errors display area*/ 
					<ul className="validation_errors" id={"validation_errors"+this.props.id} ref="validation"></ul>
				  </div>
				  <div className="modal-footer">
					<button type="button" className="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" className="btn btn-primary" ref="" data-delete="" onClick={this.updateContacts.bind(this)} id="modal-save">Update</button>
				  </div>
				</div>
			  </div>
		</div>
	  );
	}
}

export default ContactUpdate;