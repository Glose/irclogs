var delayedSearch, headerSearch, logs, lastSearch;

headerSearch = $('.header-search');
logs = $('.logs');

logs.on('contentChanged', function(){
	$('.logs .new-log').linkify({target: '_blank'});
	$('.new-log').removeClass('new-log');
	// Log navigation: do not reload the page when we are not displaying search results
	$('.logs-nav').click(function(event){
		if (!$(this).hasClass('search-entry') && window.history.replaceState) {

			// Remove existing highlights
			$('.log-highlight').removeClass('log-highlight');
			$($(this).children()[0]).addClass('log-highlight');

			// Edit history
			window.history.replaceState({}, '', $(this).attr('href'));
			moveTo(this);
			return false;
		}
	});
	$('.logs a').click(function(evt){
		evt.stopPropagation();
	})
});

logs.trigger('contentChanged');

// Search ---------------------------------------------------------- /

function searchQuery(url) {
	window.clearTimeout(delayedSearch);

	delayedSearch = setTimeout(function () {
		$.get(url, function (results) {
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
	if (query === lastSearch) {
		return false;
	}

	if (query !== '') {
		window.history.replaceState({}, '', url);
	}

	// Fade out logs during search and cache the last query
	url = headerSearch.attr('action') + '/' + query;
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

// Highlight current message and scroll to it
function moveTo(elem, speed) {
	$('body').animate({
		scrollTop: $(elem).offset().top - $('header').height()
	}, speed);
}
$(window).load(function() {
	message = $(window.location.hash);
	if (message.length) {
		message.addClass('log-highlight');
		moveTo(message, 0);
	}
	else if (logs.data('first-log')) {
		moveTo(logs.data('first-log'), 0);
	}
});
