jQuery(function ($) {

	// submit project form
	$('#projectForm').on('submit', function () {

		//f3-form-error
		var error = false;
		var errorclass = 'f3-form-error';

		$('input.field_required').each(function () {
			if ($(this).val() === '') {
				$(this).addClass(errorclass);
				error = true;
			} else if ($(this).hasClass('field_required_integer') && (isNaN(parseInt($(this).val())) || parseInt($(this).val(), 10) < 1)) {
				$(this).addClass(errorclass);
				error = true;
			} else {
				$(this).removeClass(errorclass);
			}
		});

		if (error) {
			return false;
		} else {
			return true;
		}

	});

});