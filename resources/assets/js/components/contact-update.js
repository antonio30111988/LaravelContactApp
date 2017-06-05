import React, { Component } from 'react';

//Contact search component
class ContactUpdate extends Component {
	constructor(props, context) {
		super(props, context);
		this.updateContacts=this.updateContacts.bind(this);
		this.updateParentContacts=this.updateParentContacts.bind(this);	
		this.setState({
			contact:{}
		});
	}
	componentDidMount(){
		this.setState({
			contact:this.props.contact
		});
	}
	updateParentContacts(){
		this.props.updateContacts();
	}
	updateContacts(){
		//reset errors box
		$("#validation_errors"+this.props.contact.id).html("");
		$("#validation_errors"+this.props.contact.id).removeClass("alert");
		$("#validation_errors"+this.props.contact.id).removeClass("alert-danger");
		$("#success-update").removeClass("alert");
		$("#success-update").removeClass("alert-success");
		
		var id=this.props.contact.id;
		//main contact object
	//	var contact=this.state.contact;
		
		var edited_name = this.refs.edit_name.value;
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
		console.log("ID "+id); 
		
		//ajax request for updating data
		$.post('/contacts/update', { 
			_token: csrf_token,
			id: id,
			name: edited_name, 
			nick_name: edited_nick_name, 
			company: edited_company, 
			email: edited_email, 
			phone: edited_phone, 
			address: edited_address, 
			gender: edited_gender, 
			birth_date: edited_birth_date, 
		},function() {
			this.updateParentContacts();
			
			//display success info
			$("#validation_errors"+id).after().html("<div id='success-update'>Contact successfully updated.</div>");
			$("#success-update").addClass("alert");
			$("#success-update").addClass("alert-success");
			
			//info fade after 3 sec
			setTimeout(function(){
				$("#success-update").fadeOut("slow");
			},3000);
			
			//modal hide after 2 sec
			setTimeout(function(){
				$("#show-modal-update").modal('hide');
			},2000);
		}.bind(this)).fail(function(xhr, status, error) {
			//if errors detetcted
			if(xhr.status==422){
				var jso=jQuery.parseJSON(xhr.responseText);
				
				//valdation area style
				$("#validation_errors"+id).addClass("alert");
				$("#validation_errors"+id).addClass("alert-danger");
				
				jQuery.each(jso, function(i, val) {
					jQuery.each(val, function() {
						$("#validation_errors"+id).append("<li>"+this+"</li>");
					});
				});
			}
		});
    }
	_handleNameChange(event,name) {
		const contactDef=this.state.contact;
		contactDef[name]=event.target.value;
		this.setState(
		{
			contact:contactDef
		});
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
									<label htmlFor="name" className="control-form-label">Name</label>
									<div className="input-group">
										<div className="input-group-addon ">
											<span className="glyphicon glyphicon-user"></span>
										</div>
										<input className="form-control " type="text" id="editName" name="name" ref="edit_name" value={this.props.contact.name} onChange={this._handleNameChange.bind(this,"name")}   />
									</div>
								</div>
								<div className="form-group ">
									<label htmlFor="birth_date" className="control-form-label">Birth date</label>
									<div className="input-group">
										<div className="input-group-addon ">
											<span className="glyphicon glyphicon-calendar"></span>
										</div>
										<input className="form-control" type="date" id="editBirthDate" name="birth_date" ref="edit_birth_date" onChange={this._handleNameChange.bind(this,"birth_date")} value={this.props.contact.birth} />
									</div>
								</div>
								<div className="form-group ">
									<label htmlFor="phone" className="control-form-label">Telephone</label>
									<div className="input-group">
										<div className="input-group-addon ">
											<span className="glyphicon glyphicon-phone-alt"></span>
										</div>
										<input className="form-control " type="tel" id="editPhone" name="phone"  ref="edit_phone" onChange={this._handleNameChange.bind(this,"phone")} value={this.props.contact.phone}/>
									</div>
								</div>
								<div className="form-group">
									<label htmlFor="email" className="control-form-label">Email</label>
									<div className="input-group">
										<div className="input-group-addon ">
											<span className="glyphicon glyphicon-envelope"></span>
										</div>
										<input className="form-control" type="email" id="editEmail" name="email" ref="edit_email" onChange={this._handleNameChange.bind(this,"email")} value={this.props.contact.email} />
									</div>
								</div>
								<div className="form-group">
									<label htmlFor="address" className="control-form-label">Adress</label>
									<div className="input-group">
										<div className="input-group-addon ">
											<span className="glyphicon glyphicon-map-marker"></span>
										</div>
										<input className="form-control" type="text" id="editAddress" name="address" ref="edit_address" onChange={this._handleNameChange.bind(this,"address")} value={this.props.contact.address} />
									</div>
								</div>
								<div className="form-group"> 
									<label htmlFor="company" className="control-label">Company</label>
									<div className="input-group">
										<div className="input-group-addon ">
											<span className="glyphicon glyphicon-tower"></span>
										</div>
										<input className="form-control" type="text" id="editCompany" name="company" ref="edit_company" onChange={this._handleNameChange.bind(this,"company")} value={this.props.contact.company} />
									</div>
								</div>
								<div className="form-group">
									<label htmlFor="gender" className="control-label">Gender</label>
									<select className="form-control form-control-md" value={this.props.contact.gender_flag}  ref="edit_gender" onChange={this._handleNameChange.bind(this,"gender")} id="editGender" name="gender">
										<option value="0">Choose--</option>
										<option value="1">Male</option>
										<option value="2">Female</option> 
									</select>
								</div>
								<div className="form-group ">
									<label htmlFor="nick_name" className="control-form-label">Nickname</label>
									<div className="col-10">
										<input className="form-control form-control-md" type="text" id="editNickname" name="nick_name" ref="edit_nickname" onChange={this._handleNameChange.bind(this,"nick_name")} value={this.props.contact.nick_name} />
									</div>
								</div>
							</form>
							<ul className="validation_errors" id={"validation_errors"+this.props.contact.id} ref="validation"></ul>
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