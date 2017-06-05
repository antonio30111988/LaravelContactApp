import React, { Component } from 'react';

//Contact create component
class ContactPoster extends Component {
	constructor(props) {
		//binding to this inline functions
		super(props);
		this.refreshForm=this.refreshForm.bind(this),
		this.refreshContacts=this.refreshContacts.bind(this)
	}
	refreshContacts(){
        //get contacts refresh list
		this.props.refreshContacts();
    }
	refreshForm(){
		//reset fields
		this.refs.name.value="";
		this.refs.nickname.value="";
		this.refs.birth_date.value="";
		this.refs.email.value="";
		this.refs.phone.value="";
		this.refs.address.value="";
		this.refs.company.value="";
		this.refs.gender.value=0;
	
    }
	_handleClick() {
		//reset validation div and info box
		$("#success-create").removeClass("alert");
		$("#success-create").removeClass("alert-success");
		$("#validation_errors").removeClass("alert");
		$("#validation_errors").removeClass("alert-danger");
		$("#validation_errors").html("");
	
		//fetch variables by refs tags
		var name = this.refs.name.value;
		var nick_name = this.refs.nickname.value;
		var birth_date = this.refs.birth_date.value;
		var email = this.refs.email.value;
		var phone = this.refs.phone.value;
		var address = this.refs.address.value;
		var company = this.refs.company.value;
		var gender = this.refs.gender.value;
	
		/*console.log(name);
		console.log(nick_name);
		console.log(birth_date);
		console.log(email);
		console.log(phone);
		console.log(address);
		console.log(company);
		console.log(gender);*/
		
		/*Ajax post request for inserting new contact*/
		$.post('/contacts/create', { 
			_token: csrf_token,
			name: name, 
			nick_name: nick_name, 
			company: company, 
			email: email, 
			phone: phone, 
			address: address, 
			gender: gender, 
			birth_date: birth_date, 
		}, 
		function(data) {
			//console.log(data);
			this.refreshForm();
			this.refreshContacts();
			
			//display seccess info
			$("#validation_errors").after().html("<div id='success-create'>Contact successfully created.</div>");
			$("#success-create").addClass("alert");
			$("#success-create").addClass("alert-success");
			
			//info fade after 3 sec
			setTimeout(function(){
				$("#success-create").fadeOut("slow");
			},3000);
		}.bind(this))
		.fail(function(xhr, status, error) {
			//alert(xhr.responseText);
			if(xhr.status==422){
				var jso=jQuery.parseJSON(xhr.responseText);
				
				//valdation area style
				$("#validation_errors").addClass("alert");
				$("#validation_errors").addClass("alert-danger");
				
				//append errors list
				jQuery.each(jso, function(i, val) {
					jQuery.each(val, function() {
						$("#validation_errors").append("<li>"+this+"</li>");
					});
				});
			}	
		});
	}
	render() {
		return (
			<div className="create-contact-area collapse" id="create-contact-area" data-scroll-offset="50" >
				<h2 className="create-contact"> Create new contact: </h2>
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
				<input className="create-contact btn btn-primary" type="button" value="Create" onClick={this._handleClick.bind(this)} />
				<ul className="validation_errors" id="validation_errors"></ul>
				<hr className="divide"/>
			</div>
		);
	}
} 

export default ContactPoster;