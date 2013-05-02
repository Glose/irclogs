
var irc = require('irc');
var mongojs = require('mongojs');
var Pushover = require('node-pushover');

var push = new Pushover({
	token: "BcPfsT9mAWbHghyMEKritExNKCSn4K",
	user: "bF2yVCqZU9LKqcryRkCbrxfeXsy7az"
});

var client = new irc.Client('irc.freenode.net', 'irclogs', {
	channels: ['#laravel'],
});

var logs = mongojs('irclogs').collection('logs');

var Hipchat = require('node-hipchat');
var hip = new Hipchat('21d0bf9ce0e82f39de024c4d455433');


////////////////////////////////////////////////////////////////////
////////////////////////////// LISTENERS ///////////////////////////
////////////////////////////////////////////////////////////////////

var logSave = function(hash) {
	hash.time = new Date;
	logs.save(hash, {w: 0});
}

client.addListener('message', function (nick, to, text, message) {
	logSave({type: 'message', nick: nick, text: text});
	
	// Send Push notification to iPhone and HipChat:
	if (text.indexOf('mongo') !== -1) {
		hip.postMessage({room: 'reaaad', from: 'irclogs', message: nick+': '+text, color: 'gray'});
		push.send("irclogs", text);
	}
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

