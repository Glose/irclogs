
var irc = require('irc');

var client = new irc.Client('irc.freenode.net', 'irclogs', {
	channels: ['#laravel'],
});


client.addListener('message', function (nick, to, text, message) {
	console.log(nick + ' => ' + to + ': ' + text);
});

client.addListener('join', function (channel, nick, message) {
	console.log('JOIN', channel, nick, message);
});

client.addListener('part', function (channel, nick, reason, message) {
	console.log('PART', channel, nick, reason, message);
});

client.addListener('quit', function (nick, reason, channels, message) {
	console.log('QUIT', nick, reason, channels, message);
});


////////////////////////////////////////////////////////////////////
/////////////////////////// ERROR HANDLING /////////////////////////
////////////////////////////////////////////////////////////////////

client.addListener('error', function(message) {
	console.log('error: ', message);
});

