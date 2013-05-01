
var delayedSearch, headerSearch, logs;

headerSearch = $('.header-search');
logs = $('.logs');

// Search ---------------------------------------------------------- /

function searchQuery(url) {
	window.clearTimeout(delayedSearch);

	delayedSearch = setTimeout(function() {
		$.get(url, function(results) {
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
	query = $(this).text();
	url   = $(this).attr('action')+"?q=" +query;

	if (event.which == 13) {
		event.preventDefault();
	}

	searchQuery(url);
});