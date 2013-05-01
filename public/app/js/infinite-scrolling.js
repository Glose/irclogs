
// Infinite scrolling ---------------------------------------------- /

function prepareWaypoint(container, wpDirection) {

	var more = 'infinite-more-link-' + wpDirection;
	$(container).waypoint({
		offset: 'bottom-in-view',
		handler: function (direction) {
			if (direction !== wpDirection) {
				return;
			}

			var $container = $(container);
			var $more = $(more);

			$container.addClass('infinite-loading');

			$.get($more.attr('href'), function (data) {
				var $data = $($.parseHTML(data));
				var $newMore = $data.find(more);

				if (direction === 'up') {
					$container.prepend($data.find('.log-entry'));
				} else if (direction === 'down') {
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