// A $( document ).ready() block.
jQuery( document ).ready(function($) {

	jQuery.ajax({
		 type : "post",
		 dataType : "json",
		 url : jsobject.ajaxurl,
		 data : {
		 	action: "call" 
		 },
		 success: function(response) {
		 	console.log(response);
		 }
	});
})	