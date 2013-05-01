
var delayedSearch, headerSearch, logs;

headerSearch = $('.header-search');
logs = $('.logs');

logs.linkify();

// Search ---------------------------------------------------------- /

function searchQuery(url) {
	window.clearTimeout(delayedSearch);

	delayedSearch = setTimeout(function() {
		$.get(url, function(results) {
			results = $(results).linkify();
			logs.fadeTo('fast', 1).html(results);
		});
	}, 50);
}

// Header interaction ---------------------------------------------- /

// Simulate focus and placeholder behavior
headerSearch.focus();
placeholder = headerSearch.text();

headerSearch.keypress(function(event) {
	var query, url, results;

	logs.fadeTo('fast', .5);
	query = $(this).val();
	url   = $(this).attr('action')+'/'+query;

	if (event.which == 13) {
		event.preventDefault();
	}

	searchQuery(url);
});

// Timeline accordion ---------------------------------------------- /

$('li.current').parentsUntil('.timeline', 'ul').show();

$('.timeline a').click(function(event) {
	var delay = 200;

	if ($(this).attr('href') == '#') {
		event.preventDefault();

		$(this).parent().siblings().find('ul').slideUp(delay);
		$(this).parent().find('> ul').slideToggle(delay);
	}
});