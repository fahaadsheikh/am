// A $( document ).ready() block.
jQuery( document ).ready(function($) {

	jQuery.ajax({
		type : "post",
		dataType : "json",
		url : jsobject.ajaxurl,
		data : {
		 	action: "return_response" 
		},
		before: function(response) {
			$('.jspopulate').each(function(i, obj) {
			    this.innerHTML = 'Loading';
			});
		},
		success: function(response) {

			if (response.success == true) {
				parsed = JSON.parse(response.data);
				$('.jspopulate').each(function(i, obj) {
				    generateTableCaption( this, parsed.title );
				    generateTableHead( this, parsed.data.headers);
				    generateTable( this, Object.values(parsed.data.rows) );
				    console.log(parsed.last_fetched);
				});
			} else {
				$('.jspopulate').each(function(i, obj) {
				    generateTableCaption( this, response.data.error );
				});
			}
		}
	});

	function generateTableCaption(table, caption) {
		var create_caption = table.createCaption();
		create_caption.innerHTML = caption;
	}

	function generateTableHead(table, data) {
		let thead = table.createTHead();
		let row = thead.insertRow();
	  	for (let key of data) {
	    	let th = document.createElement("th");
	    	let text = document.createTextNode(key);
	    	th.appendChild(text);
	    	row.appendChild(th);
	  	}
	}

	function generateTable(table, data) {
		for (let element of data) {
	    	let row = table.insertRow();
    		for (key in element) {
      			let cell = row.insertCell();
      			let text = document.createTextNode(element[key]);
      			cell.appendChild(text);
    		}
	  	}
	}

})	