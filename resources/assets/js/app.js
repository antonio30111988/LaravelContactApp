
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./react_main.js');

//jquery on dom load
$(document).ready(function(){
    //on main header menu item click scroll to point
	$(".scrollto").click(function(event){
        event.preventDefault(); 
		//alert("scroll");
        var defaultAnchorOffset = 0;
        var anchor = $(this).attr('data-attr-scroll');
		//alert("anchor"+anchor);
        var anchorOffset = $(anchor).attr('data-scroll-offset');
        if (!anchorOffset)
            anchorOffset = defaultAnchorOffset; 

		//animate down from top of page
        $('html,body').animate({ 
            scrollTop: $(anchor).offset().top - anchorOffset
        }, 1000);        
    });
	
	//on click export contact to vCard
	$(document.body).on('click','.export',function(){
		if($(this).attr("data-id")){
			//alert("click");
			$("#"+id).removeClass("btn-success");
			$("#"+id).addClass("btn-warning");
			$("#"+id).text("to vCard");
		
			var id=$(this).attr("data-id");
		
			$.post('/contacts/export', {_token: csrf_token,id:id}, function(data) {
				//alert("joo");
				$("#"+id).removeClass("btn-warning");
				$("#"+id).addClass("btn-success");
				$("#"+id).text("Saved");
				//console.log(data);
				//console.log(data.id);
			});
		}
	});
}); 

