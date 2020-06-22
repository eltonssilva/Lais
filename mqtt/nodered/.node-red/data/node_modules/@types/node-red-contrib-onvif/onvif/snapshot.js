module.exports = (RED) => {
    "use strict";
    let onvif = require("node-onvif");

    function snapshot(config) {
        RED.nodes.createNode(this, config);
        
        this.active = config.active;
        var node = this;
        
    

        if (config.url) {
            config.url = 'http://' + config.url + '/onvif/device_service';
        }
        // if (node.active == false) return;

        // config.interval = parseInt(config.interval);
        // node.intervalId = null;

        // runInterval(node, config);

        this.on('input', function (msg) {
            
            config.interval = 1;
            
            if (msg.ip != null) {
                config.url = 'http://' + msg.ip + '/onvif/device_service';
                config.ip = msg.ip;
                config.device_atuador_codigo = msg.device_atuador_codigo;
                config.delay = msg.delay;
                config.country = msg.country;
                config.secret_key = msg.secret_key;
            }

            if (msg.username != null) {
                config.username = msg.username;
            }


            if (msg.password != null) {
                config.password = msg.password;
            }

            node.intervalId = null;
            runInterval(node, config);
            // if (this.intervalId != null) {
            //     clearInterval(this.intervalId);
            // }
      
        });

        // node.on("close", () => {
        //     if (this.intervalId != null) {
        //         clearInterval(this.intervalId);
        //     }
        // });
    }
    RED.nodes.registerType("ONVIF Snapshot", snapshot);

    RED.httpAdmin.post("/onvif-snapshot/:id/:state", RED.auth.needsPermission("onvif-snapshot.write"), (req, res) => {
        var node = RED.nodes.getNode(req.params.id);
        var state = req.params.state;
        if (node !== null && typeof node !== "undefined" ) {
            if (state === "enable") {
                node.active = true;
                res.sendStatus(200);
            } else if (state === "disable") {
                node.active = false;
                res.sendStatus(201);
            } else {
                res.sendStatus(404);
            }
        } else {
            res.sendStatus(404);
        }
    });

    function runInterval(node, config) {
        if (node.intervalId != null) {
            clearInterval(node.intervalId);
        }
        node.log("URL (" + config.interval + " seconds): " + config.url);

        let msg = {
            name: config.name,
            url: config.url,
            error: false
        };

        let fetch = function() {
            let onvifInstance = new onvif.OnvifDevice({
                xaddr: config.url,
                user : config.username,
                pass : config.password
            });

            onvifInstance.init().then((info) => {
                node.log('Fetching snapshot from ' + config.url);
                return onvifInstance.fetchSnapshot();
            }).then((res) => {
                let prefix = 'data:' + res.headers['content-type'] + ';base64,';
                let base64Image = Buffer.from(res.body, 'binary').toString('base64');
                msg.payload = prefix + base64Image;
              //  msg.payload2 = base64Image;
                msg.ip = config.ip;
                msg.device_atuador_codigo = config.device_atuador_codigo;
                msg.delay = config.delay;
                msg.country = config.country;
                msg.secret_key = config.secret_key;

                msg.binaryImage = res.body;
                node.send(msg);
            }).catch((error) => {
                msg.payload = null;
             //   msg.payload2 = null;
                msg.ip = config.ip;
                msg.error = error;
                node.send(msg);
            });
        }
        fetch();
        // node.intervalId = setInterval(() => {
        //     fetch();
        // }, config.interval * 1000);
    }
}
