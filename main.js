var fs = require('fs');

var config = require('./botconfig/default');
if (fs.existsSync('./botconfig/local.js')) {
	var localConfig = require('./botconfig/local');
	for (i in localConfig) {
		config[i] = localConfig[i];
	}
}


////////////////////////////////////////////////////////////////////
////////////////////////////// LISTENERS ///////////////////////////
////////////////////////////////////////////////////////////////////

var logSave = function(hash) {
	hash.time = new Date;
	config.logs.save(hash, {w: 0});
}

config.client.addListener('message', function (nick, to, text, message) {
	logSave({type: 'message', nick: nick, text: text});
	
	// Send Push notification to iPhone and HipChat:
	if (text.toLowerCase().indexOf('mongo') !== -1) {
		if (config.hipchat) {
			config.hipchat.postMessage({room: 'reaaad', from: 'irclogs', message: nick+': '+text, color: 'gray'});
		}
		if (config.pushover) {
			config.pushover.send("irclogs", text);
		}
	}
});

config.client.addListener('join', function (channel, nick, message) {
	logSave({type: 'join', nick: nick});
});

config.client.addListener('part', function (channel, nick, reason, message) {
	logSave({type: 'part', nick: nick, reason: reason});
});

config.client.addListener('quit', function (nick, reason, channels, message) {
	logSave({type: 'quit', nick: nick, reason: reason});
});


////////////////////////////////////////////////////////////////////
/////////////////////////// ERROR HANDLING /////////////////////////
////////////////////////////////////////////////////////////////////

config.client.addListener('error', function(message) {
	console.log('error: ', message);
});

