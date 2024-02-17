jQuery(document).ready(function ($) {

	// Voir Mot de passe
	var _voir = $('<button type="button" class="voir-btn" data-toggle="0" aria-label="Afficher le mot de passe"><span class="voir" aria-hidden="true">Voir</span></button>');
	_voir.insertBefore($('#user_pass'));

	_voir.on('click', function () {
		var _input = $('#user_pass');
		if (_input.attr('type') == 'password') {
			_input.attr('type', 'text');
		} else {
			_input.attr('type', 'password');
		}
	});

	$("#modal").hide();
	$("#acf-button").click(function () {
		$("#modal").toggle();
	});


});
