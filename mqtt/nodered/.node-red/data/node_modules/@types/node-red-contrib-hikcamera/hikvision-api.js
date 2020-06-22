var net = require('net');
var events = require('events');
var util = require('util');
var xml2js = require('xml2js');

var TRACE = false;
var BASEURI = false;
var parser = new xml2js.Parser();

var hikvisionApi = function (options) {

	events.EventEmitter.call(this)
	this.client = this.connect(options)
	if (options.log) TRACE = options.log;
	BASEURI = 'http://' + options.host + ':' + options.port
	this.detectedEvents = {};

};

util.inherits(hikvisionApi, events.EventEmitter);

hikvisionApi.prototype.connect = function (options) {

	var self = this;
	var authHeader = 'Authorization: Basic ' + new Buffer.from(options.user + ':' + options.pass).toString('base64');

	var client = net.connect(options, function () {

		var header = 'GET /ISAPI/Event/notification/alertStream HTTP/1.1\r\n' +
			'Host: ' + options.host + ':' + options.port + '\r\n' +
			authHeader + '\r\n' +
			'Accept: multipart/x-mixed-replace\r\n\r\n';

		client.write(header)
		client.setKeepAlive(true, 1000)
		handleConnection(self, options);

	});

	client.on('data', function (data) {

		handleData(self, data)

	});

	client.on('close', function () {

		setTimeout(function () {
			self.connect(options)
		}, 15000);

		handleEnd(self);

	});

	client.on('error', function (err) {

		handleError(self, err)

	});

}

function handleData(self, data) {
	
	var parseData = '';

	var n = data.indexOf('<EventNotificationAlert');
	if (n > -1) {
		parseData = data.toString().slice(n);
	} else {
		return;
	}

	parser.parseString(parseData, (err, result) => {
		
		if (err) console.log('parse err ' + err);

		if (result !== undefined && result !== null) {

			if (result['EventNotificationAlert'] !== undefined) {

				var code = result['EventNotificationAlert']['eventType'][0];

				/* we are only interested in Motion Detection or Line Crossing */
				if (!((code === 'VMD') || (code === 'linedetection'))) {
					return;
				}

				var state = result['EventNotificationAlert']['eventState'][0];
				var index = parseInt(result['EventNotificationAlert']['channelID'][0]);
				var count = parseInt(result['EventNotificationAlert']['activePostCount'][0]);

				var eventIndex = code+index;
				var e = {code: code, state: state, index: index, count: count, lastSeen: Date.now() / 1000, send: false};

				if (self.detectedEvents[eventIndex] !== undefined) { /* seen this one before */
					if (self.detectedEvents[eventIndex].lastSeen < (e.lastSeen - 30)) { /* older than 30 seconds */
						e.send = true;
						self.detectedEvents[eventIndex] = e;
					}
				} else { /* this is a new one */
					e.send = true;
					self.detectedEvents[eventIndex] = e;
				}

				if (e.state === 'inactive') { /* always send these */
					self.emit('alarm', e.code, e.state, e.index);
				} else if (e.state === 'active') {
					if (e.send) {
						self.emit('alarm', e.code, e.state, e.index);
					}
				}

			}
		}
	});

}

function handleConnection(self, options) {

	if (TRACE) console.log('Connected to ' + options.host + ':' + options.port)
	self.emit("connect");

}

function handleEnd(self) {

	if (TRACE) console.log("Connection closed!");
	self.emit("end");

}

function handleError(self, err) {

	if (TRACE) console.log("Connection error: " + err);
	self.emit("error", err);

}

String.prototype.startsWith = function (str) {

	return this.slice(0, str.length) == str;

};

exports.hikvisionApi = hikvisionApi;
