import React from 'react';
import ReactDOM from 'react-dom';

//Contact display list component
export default class ContactDisplay extends React.Component{
	getInitialState: function() {
		return {
			editinput: false
		};
	},
	_removeItem: function() {
		$("#show-modal").modal();	
		$("#modal-save").attr('data-delete',this.props.id);	
	},
	_editItem: function() {
		alert("DARTE:"+this.props.contact.birth);
		this.state.editinput ? this.setState({ editinput: false }) : this.setState({ editinput: true });
	},
	_handleSubmit: function() {
		$("#validation_errors"+this.props.id).html("");

		var id=this.props.id;
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
			this.setState({ editinput: false });
		}.bind(this)).fail(function(xhr, status, error) {
       
			//alert(error);
			//alert(status);
			//alert(xhr);
			alert(xhr.responseText);
			alert("CODE "+xhr.status);
			
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
	},
	_handleNameChange: function() {
		this.setState({ [event.target.ref]: event.target.value });
	 },
	render: function() {
		return(
			<div className="contact-item" id={this.props.contact.id}>
				
				<span className="do-delete glyphicon glyphicon-remove" onClick={this._removeItem}  ></span>
			
				<div className=" contact contact-main">
					<h3 className=" contact " ><span className="contact-labels glyphicon glyphicon-user"></span>  {!this.state.editinput ? <span className="contact-name">{this.props.contact.name}</span>: <input type="text" id="editName"  ref="edit_name" onChange={this._handleNameChange} defaultValue={this.props.contact.name}  placeholder="Name"   />  }  {!this.state.editinput ? <span className="contact-birth-date">{ (this.props.contact.age>0)? this.props.contact.age+'yrs':''} </span>: <input type="date" id="editBirthDate" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.birth}  placeholder="Birth Date" ref="edit_birth_date"  />  }</h3>	
				</div>
				<div className=" contact contact-info">
				<h4 className="contact contact-phone"><span className="contact-labels glyphicon glyphicon-phone-alt"></span> {!this.state.editinput ? <span className="contact-content">{this.props.contact.phone}</span>: <input type="text" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.phone}  placeholder="Name" ref="edit_phone"  />  }</h4> 					

				<h4 className=" contact contact-email"><span className="contact-labels glyphicon glyphicon-envelope"></span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.email}</span>: <input type="email" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.email}  placeholder="Email" ref="edit_email"  />  }</h4>
				<h4 className=" contact contact-address"><span className="contact-labels glyphicon glyphicon-map-marker"></span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.address}</span>: <input type="text" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.address}  placeholder="Adress" ref="edit_address"  />  }</h4>
				<h4 className=" contact contact-company"><span className="contact-labels glyphicon glyphicon-tower"></span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.company}</span>: <input type="text" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.company}  placeholder="Company" ref="edit_company"  />  }</h4>
				</div>
				<div className=" contact contact-additional">
					<p className=" contact contact-gender"><span className="contact-labels">Sex:</span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.gender}</span>: 
					<select defaultValue={this.props.contact.gender_flag}  className="contact-input editInputs select-gender" onChange={this._handleNameChange} ref="edit_gender" >
				<option  value="0">Choose gender</option>
				<option  value="1">Male</option>
				<option   value="2">Female</option>
			</select>  }</p>
					<p className=" contact contact-nickname"><span className="contact-labels">Nickname:</span>  {!this.state.editinput ? <span className="contact-content">{this.props.contact.nick_name}</span>: <input type="text" id="nickname_input" className="editInputs" onChange={this._handleNameChange} defaultValue={this.props.contact.nick_name}  placeholder="Nickname" ref="edit_nickname"  />  }</p>
				</div>
				
				<div className="do-edit-save">
				{this.state.editinput ?	
					<button onClick={this._handleSubmit} className="do-save btn btn-success btn-sm" > Save </button>
					

				: '' }
				<button  onClick={this._editItem} className="do-edit btn btn-danger btn-sm">
					<span className="  glyphicon glyphicon-edit"></span> Edit
				</button>
				</div>
				<ul className="validation_errors" id={"validation_errors"+this.props.id} ref="validation"></ul>
			
				
			</div> 
			
		);
	}
}
