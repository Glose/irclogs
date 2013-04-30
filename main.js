
var irc = require('irc');
var mongojs = require('mongojs');


var client = new irc.Client('irc.freenode.net', 'irclogs', {
	channels: ['#laravel'],
});

var logs = mongojs('irclogs').collection('logs');


client.addListener('message', function (nick, to, text, message) {
	console.log(nick + ' => ' + to + ': ' + text);
	logs.save({type: 'message', nick: nick, text: text}, {w: 0});
});

client.addListener('join', function (channel, nick, message) {
	console.log('JOIN', channel, nick, message);
	logs.save({type: 'join', nick: nick}, {w: 0});
});

client.addListener('part', function (channel, nick, reason, message) {
	console.log('PART', channel, nick, reason, message);
	logs.save({type: 'part', nick: nick, reason: reason}, {w: 0});
});

client.addListener('quit', function (nick, reason, channels, message) {
	console.log('QUIT', nick, reason, channels, message);
	logs.save({type: 'quit', nick: nick, reason: reason}, {w: 0});
});


////////////////////////////////////////////////////////////////////
/////////////////////////// ERROR HANDLING /////////////////////////
////////////////////////////////////////////////////////////////////

client.addListener('error', function(message) {
	console.log('error: ', message);
});

