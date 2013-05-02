
// Infinite scrolling ---------------------------------------------- /

function prepareWaypoint(container, wpDirection) {

	var more = '.infinite-more-link-' + wpDirection;
	var $container = $(container);
	var offset;
	if (wpDirection == 'down') {
		offset = 'bottom-in-view';
	}
	else {
		offset = $('header').height();
	}
	
	
	$container.waypoint({
		offset: offset,
		handler: function (direction) {
			if (direction !== wpDirection) {
				return;
			}
			var $more = $(more);
			if (!$more.length) {
				return; // No way to disable only the up or the down waypoint
			}
			$container.waypoint('disable');
			$container.addClass('infinite-loading');
			
			$.get($more.attr('href'), function (data) {
				var $data = $($.parseHTML(data));
				$more.remove();
				
				if (direction === 'up') {
					var scrollTo = $($('.logs').children()[0]);
					$container.prepend($data.children());
					moveTo(scrollTo, 0);
				} else if (direction === 'down') {
					$container.append($data.children());
				}
				$container.trigger('contentChanged');

				$container.removeClass('infinite-loading');
				$container.waypoint('enable');
			});
		}
	});

}

prepareWaypoint('.logs', 'up');
prepareWaypoint('.logs', 'down');
