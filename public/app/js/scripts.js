$('.header__search').focus();

$('.header__search').keypress(function(event) {
  if (event.which == 13) {
    event.preventDefault();

  	url = $(this).attr('action');
		$.get(url, function(results) {
			$('.logs').html(results);
		});
	}
});