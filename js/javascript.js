// A $( document ).ready() block.
jQuery( document ).ready(function($) {

	jQuery.ajax({
		 type : "post",
		 dataType : "json",
		 url : jsobject.ajaxurl,
		 data : {
		 	action: "get_cached_results" 
		 },
		 success: function(response) {
		 	console.log(response);
		 }
	});
})	