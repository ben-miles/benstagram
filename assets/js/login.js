(function() {
	"use strict";

	var formSubmitButton = document.getElementById("login-submit");
	formSubmitButton.addEventListener('click', function(e) {
		e.preventDefault();
		ajaxFormSubmit("login-logic");
	});

})()