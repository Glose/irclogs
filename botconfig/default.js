var irc = require('irc');
var mongojs = require('mongojs');

module.exports = {
	client: new irc.Client('irc.freenode.net', 'irclogs', {
		channels: ['#laravel'],
	}),
	logs: mongojs('irclogs').collection('logs'),
	hipchat: null,
	pushover: null,
};
