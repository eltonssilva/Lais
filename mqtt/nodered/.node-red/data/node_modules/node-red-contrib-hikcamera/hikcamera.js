module.exports = function(RED) {

    "use strict";

    var HikvisionAPI = require('./hikvision-api').hikvisionApi;
    var http = require('http');

    function HikcameraCredentialsNode(config) {

        RED.nodes.createNode(this, config);
        var node = this;

        let options = {
            host: this.credentials.host,
            port: this.credentials.port,
            user: this.credentials.username,
            pass: this.credentials.password,
            log: false,
        };

        this.options = options;

    }

    HikcameraCredentialsNode.prototype.connect = function(node) {

        var hikApi = null;

        node.status({
            fill: "red",
            shape: "ring",
            text: "disconnected"
        });

        if (this.options != null) {

            hikApi = new HikvisionAPI(this.options);

            hikApi.on('error', (err) => {
                node.error(err);
                node.status({
                    fill: "red",
                    shape: "ring",
                    text: "error"
                });
            });

            hikApi.on('connect', (err) => {
                node.status({
                    fill: "green",
                    shape: "ring",
                    text: "connected"
                });
            });

            hikApi.on('end', (err) => {
                node.error(err);
                node.status({
                    fill: "red",
                    shape: "ring",
                    text: "disconnected"
                });
            });

        }

        return hikApi;

    }

    RED.nodes.registerType("hikcamera-credentials", HikcameraCredentialsNode, {

        credentials: {
            host: {
                type: "text"
            },
            port: {
                type: "text"
            },
            username: {
                type: "text"
            },
            password: {
                type: "password"
            }
        }

    });

    function HikcameraAlarmInNode(config) {

        RED.nodes.createNode(this, config);
        var node = this;

        this.hikcamera = RED.nodes.getNode(config.hikcamera);

        this.hikApi = this.hikcamera.connect(node);

        if (this.hikApi != null) {

            this.hikApi.on('alarm', function(code, action, index) {

                let data = {
                    'code': code,
                    'action': action,
                    'index': index,
                    'time': new Date()
                };

                node.send({
                    payload: data
                });

            });

        } else {

            node.error("Invalid credentials");

            node.status({
                fill: "red",
                shape: "ring",
                text: "conf invalid"
            });

        }

        this.on('close', function(done) {

            node.hikApi.client.destroy();
            done();

        });

    }

    RED.nodes.registerType("hikcamera-alarm-in", HikcameraAlarmInNode);

    function HikcameraImageInNode(config) {

        RED.nodes.createNode(this, config);
        var node = this;

        this.hikcamera = RED.nodes.getNode(config.hikcamera);

        this.http_options = {
            host: this.hikcamera.options.host,
            port: this.hikcamera.options.port,
            path: '/Streaming/Channels/101/Picture',
            headers: {
                'Authorization': "Basic " + new Buffer(this.hikcamera.options.user + ":" + this.hikcamera.options.pass).toString('base64')
            }
        };

        if (this.hikcamera.options != null) {
            this.on('input', function(msg) {
                http.get(this.http_options, function(response) {
                    var data = [];
                    response.on('data', function(d) {
                        data.push(d);
                    });
                    response.on('end', function() {
                        if (response.statusCode != 200) {
                            node.error("Invalid status code", msg);
                            node.status({
                                fill: "red",
                                shape: "ring",
                                text: "communication error"
                            });
                        } else {
                            msg.payload = Buffer.concat(data);
                            node.send(msg);
                            node.status({
                                fill: "green",
                                shape: "ring",
                                text: "successful"
                            });
                        }
                    });
                });
            });
        } else {
            node.error("Invalid credentials");
            node.status({
                fill: "red",
                shape: "ring",
                text: "conf invalid"
            });
        }
    }

    RED.nodes.registerType("hikcamera-image-in", HikcameraImageInNode);

}
