
var irc = require('irc');

var client = new irc.Client('irc.freenode.net', 'irclogs', {
	channels: ['#laravel'],
});


client.addListener('message', function (from, to, message) {
	console.log(from + ' => ' + to + ': ' + message);
});

client.addListener('join', function (channel, nick, message) {
	console.log('JOIN', channel, nick, message);
});

////////////////////////////////////////////////////////////////////
/////////////////////////// ERROR HANDLING /////////////////////////
////////////////////////////////////////////////////////////////////

client.addListener('error', function(message) {
	console.log('error: ', message);
});

