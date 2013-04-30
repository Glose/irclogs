
var irc = require('irc');
var mongojs = require('mongojs');


var client = new irc.Client('irc.freenode.net', 'irclogs', {
	channels: ['#laravel'],
});

var logs = mongojs('irclogs').collection('logs');

var logSave = function(hash) {
	console.log(hash);
	hash.time = new IsoDate;
	logs.save(hash, {w: 0});
}

client.addListener('message', function (nick, to, text, message) {
	logSave({type: 'message', nick: nick, text: text});
});

client.addListener('join', function (channel, nick, message) {
	logSave({type: 'join', nick: nick});
});

client.addListener('part', function (channel, nick, reason, message) {
	logSave({type: 'part', nick: nick, reason: reason});
});

client.addListener('quit', function (nick, reason, channels, message) {
	logSave({type: 'quit', nick: nick, reason: reason});
});


////////////////////////////////////////////////////////////////////
/////////////////////////// ERROR HANDLING /////////////////////////
////////////////////////////////////////////////////////////////////

client.addListener('error', function(message) {
	console.log('error: ', message);
});

