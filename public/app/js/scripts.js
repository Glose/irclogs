$('.header').focus();

$('.header').keypress(function(event) {
	if (event.which == 13) {
		url = $(this).attr('action');
		$.get(url, function(results) {
			console.log(results);
		});
	}
});