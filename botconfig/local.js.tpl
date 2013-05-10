var Pushover = require('node-pushover');
var Hipchat = require('node-hipchat');

module.exports = {
	hipchat: new Hipchat('token'),
	pushover: new Pushover({
		token: "token",
		user: "User token"
	}),
};
