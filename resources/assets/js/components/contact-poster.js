import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact post component
class ContactPoster extends Component {
	refreshContacts(){
        this.props.refreshContacts();
    }
	_handleClick() {
		
		$("#validation_errors").html("");

		var name = this.refs.name.value;
		var nick_name = this.refs.nickname.value;
		var birth_date = this.refs.birth_date.value;
		var email = this.refs.email.value;
		var phone = this.refs.phone.value;
		var address = this.refs.address.value;
		var company = this.refs.company.value;
		var gender = this.refs.gender.value;
	
		console.log(name);
		console.log(nick_name);
		console.log(birth_date);
		console.log(email);
		console.log(phone);
		console.log(address);
		console.log(company);
		console.log(gender);
		
		$.post('/contacts/create', 
		{ 
			_token: csrf_token,
			name: name, 
			nick_name: nick_name, 
			company: company, 
			email: email, 
			phone: phone, 
			address: address, 
			gender: gender, 
			birth_date: birth_date, 
			
		}, function(data) {
			console.log(data);
			//this._refreshContacts();
		}).fail(function(xhr, status, error) {
       
			//alert(error);
			//alert(status);
			//alert(xhr);
			alert(xhr.responseText);
			
			if(xhr.status==422)
			{
				var jso=jQuery.parseJSON(xhr.responseText);
				//alert(jso.email);
			
				jQuery.each(jso, function(i, val) {
					jQuery.each(val, function() {
						$("#validation_errors").append("<li>"+this+"</li>");
					});
					//$("#validation_errors").append("<li>"+val+"</li>");
				});
			}	
		});
		this.refreshContacts();
	}
	render() {
	  return (
		<div className="create-contact-area">
			<input className="contact-input" type="text" placeholder="Name" ref="name" required />
			<input className="contact-input" type="text" placeholder="Nickname" ref="nickname" />
			<input className="contact-input" type="email" placeholder="Email" ref="email" required />
			<input className="contact-input" type="email" placeholder="Phone (01...)" ref="phone" required />
			<input className="contact-input" type="text" placeholder="Adress" ref="address" required />
			<input className="contact-input" type="text" placeholder="Company" ref="company" required />
			<input className="contact-input" type="date" id="birth_date"  placeholder="Birth date" ref="birth_date" />
			<select className="contact-input select-gender" ref="gender">
				<option value="0">Choose gender</option>
				<option value="1">Male</option>
				<option value="2">Female</option>
			</select>
			<input className="create-contact btn btn-primary" type="button" value="Create" onClick={this._handleClick} />
			
			<ul className="validation_errors" id="validation_errors"></ul>
			<hr className="divide"/>
		</div>
	  );
	}
} 

export default ContactPoster;