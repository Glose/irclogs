var delay, delayedSearch;

// Search ---------------------------------------------------------- /

function searchQuery(url) {
  clearTimeout(delayedSearch);

  delayedSearch = setTimeout(function() {
    $.get(url, function(results) {
      $('.logs').html(results);
    });
  }, 50);
}

// Header interaction ---------------------------------------------- /

$('.header-search').focus();

$('.header-search').keypress(function(event) {
  var query, url, results, delay, _this = this;

  if (event.which == 13) {
    event.preventDefault();
  }

  query = $(this).text();
	url   = $(this).attr('action')+"?q=" +query;
  searchQuery(url);
});