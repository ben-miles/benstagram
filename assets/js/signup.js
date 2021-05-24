(function() {
	"use strict";

	var formSubmitButton = document.getElementById("signup-submit");
	formSubmitButton.addEventListener('click', function(e) {
		e.preventDefault();
		ajaxFormSubmit("signup-logic");
	});

})()