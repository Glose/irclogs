var delayedSearch, headerSearch, logs, lastSearch;

headerSearch = $('.header-search');
logs = $('.logs');

logs.on('contentChanged', function(){
	$('.logs li').linkify({target: '_blank'});
});
logs.trigger('contentChanged');

// Search ---------------------------------------------------------- /

function searchQuery(url) {
	window.clearTimeout(delayedSearch);

	delayedSearch = setTimeout(function () {
		$.get(url, function (results) {
			results = $(results).linkify();
			logs.fadeTo('fast', 1).html(results).trigger('contentChanged');
		});
	}, 50);
}

// Header interaction ---------------------------------------------- /

// Simulate focus and placeholder behavior
headerSearch.focus();

headerSearch.keyup(function (event) {
	var query, url;

	// Get query to execute, cancel if twice the same query
	query = $(this).val();
	url = $(this).attr('action') + '/' + query;
	if (query === lastSearch || query === '') {
		return false;
	}

	// Fade out logs during search and cache the last query
	logs.stop(true).fadeTo('fast', 0.5);
	lastSearch = query;

	if (event.which === 13) {
		event.preventDefault();
	}

	searchQuery(url);
});

// Timeline accordion ---------------------------------------------- /

$('li.current').parentsUntil('.timeline', 'ul').show();

$('.timeline a').click(function (event) {
	var delay = 200;

	if ($(this).attr('href') === '#') {
		event.preventDefault();

		$(this).parent().siblings().find('ul').slideUp(delay);
		$(this).parent().find('> ul').slideToggle(delay);
	}
});

// Move to the requested datetime
if (logs.data('first-log')) {
	var offset = $(logs.data('first-log')).offset();
	$('html, body').animate({
		scrollTop: offset.top - $('header').height()
	}, 0);
}
