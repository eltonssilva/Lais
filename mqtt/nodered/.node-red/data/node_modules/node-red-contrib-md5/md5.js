/**
 * Copyright 2016 Dean Cording <dean@cording.id.au>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 **/

const util = require('util');

module.exports = function(RED) {
    "use strict";
    var md5 = require("md5");

    function MD5Node(n) {
        RED.nodes.createNode(this,n);
        var node = this;

        node.name = n.name;
        node.fieldToHash = n.fieldToHash || "payload";
        node.fieldTypeToHash = n.fieldTypeToHash || "msg";
        node.hashField = n.hashField  || "md5";
        node.hashFieldType = n.hashFieldType || "msg";
        node.on("input", function(msg) {

            var hash = md5(RED.util.evaluateNodeProperty(node.fieldToHash,node.fieldTypeToHash,node,msg));

            if (node.hashFieldType === 'msg') {
                RED.util.setMessageProperty(msg,node.hashField,hash);
            } else if (node.hashFieldType === 'flow') {
                node.context().flow.set(node.hashField,hash);
            } else if (node.hashFieldType === 'global') {
                node.context().global.set(node.hashField,hash);
            }

            node.send(msg);

        });
    }

    RED.nodes.registerType("md5", MD5Node);
}

