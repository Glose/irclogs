
var delayedSearch, headerSearch, logs, lastSearch;

headerSearch = $('.header-search');
logs         = $('.logs');

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

headerSearch.keyup(function(event) {
	var query, url, results;

	// Get query to execute, cancel if twice the same query
	query = $(this).val();
	url   = $(this).attr('action')+'/'+query;
	if (query == lastSearch) return false;

	// Fade out logs during search and cache the last query
	logs.stop(true).fadeTo('fast', .5);
	lastSearch = query;

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

// Move to the requested datetime
if (logs.data('first-log')) {
	var offset = $(logs.data('first-log')).offset();
	$('html, body').animate({scrollTop: offset.top - $('header').height()}, 0);
}

// Infinite loading
function prepareWaypoint(container, wpDirection) {
	var more = 'infinite-more-link-' + wpDirection;
	$(container).waypoint({
		offset: 'bottom-in-view',
		handler: function(direction) {
			if (direction !== wpDirection) {
				return;
			}
			
			var $container = $(container);
			var $more = $(more);
			
			$container.addClass('infinite-loading');
			
			$.get($more.attr('href'), function(data) {
				var $data = $($.parseHTML(data));
				var $newMore = $data.find(more);
				
				if (direction === 'up') {
					$container.prepend($data.find('.log-entry'));
				}
				else if (direction === 'down') {
					$container.append($data.find('.log-entry'));
				}
				
				$container.removeClass('infinite-loading');
				
				if ($newMore.length) {
					$more.replaceWith($newMore);
					$container.waypoint('enable');
				} else {
					$container.waypoint('destroy');
				}
			});
		}
	});
}
prepareWaypoint('.logs', 'up');
prepareWaypoint('.logs', 'down');
