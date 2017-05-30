import React, { Component } from 'react';
import ReactDOM from 'react-dom';

//Contact search component
class ContactDelete extends Component {
	 deleteContacts(){
		 
        var id=this.props.id;  
        alert(id+"  dsvd");
		$.post('/contacts/delete',{ id: id,_token: csrf_token }, function(data) {
			console.log("ovo je id"+id);
			 this.props.deleteContacts(id);
		}.bind(this)).done(function(msg){
			$("#show-modal").modal('hide');
		});
    }
	render() {
	  return (
			<div className="modal fade" tabIndex="-1" role="dialog" id="show-modal">
			  <div className="modal-dialog" role="document">
				<div className="modal-content">
				  <div className="modal-header">
					<button type="button" className="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 className="modal-title">Delete contact</h4>
				  </div>
				  <div className="modal-body">
					Are you sure you want to delete contact?
				  </div>
				  <div className="modal-footer">
					<button type="button" className="btn btn-default" data-dismiss="modal">No</button>
					<button type="button" className="btn btn-primary" ref="" data-delete="" onClick={this.deleteContacts.bind(this)} id="modal-save">Yes</button>
				  </div>
				</div>
			  </div>
		</div>
	  );
	}
}

export default ContactDelete;