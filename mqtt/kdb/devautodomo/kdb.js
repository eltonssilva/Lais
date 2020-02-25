var dgram = require('dgram');
const fs = require('fs');
var server = dgram.createSocket('udp4');


var PORTA_ENTRADA =1979;
var PORTA_SAIDA = 1980;
var HOST = '127.0.0.1';

var PinServidor="";


server.on('listening', function() {
  var address = server.address();
 console.log('UDP Server listening on ' + address.address + ':' + address.port);
});

server.on('message', function(message, remote) {


let device = fs.readFileSync('/home/node/app/configs/config.json');
let PinServidor = JSON.parse(device);
let dadosRemoteDevice = JSON.parse(message + "");
var dados_servidor="";

if (dadosRemoteDevice.tipo == "kdb")
{
  dados_servidor = '{ "nome": "' + PinServidor.nome + '", "pin": "' + PinServidor.pin + '", "ip": "' + PinServidor.ip + '"}';
  console.log(message + "");
  enviar_broker(remote.address, dados_servidor)
}
console.log(remote.address + ':' + remote.port +' - ' + dados_servidor);

 
});

server.bind(PORTA_ENTRADA);




function enviar_broker(_HOST, _PinServidor)
{
  var message = new Buffer(_PinServidor);

  var client = dgram.createSocket('udp4');
  client.send(message, 0, message.length, PORTA_SAIDA, _HOST, function(err, bytes) {
    if (err) throw err;
    console.log('UDP message sent to ' + HOST +':'+ PORTA_ENTRADA);
    client.close();
  });
}
