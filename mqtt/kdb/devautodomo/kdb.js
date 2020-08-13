var dgram = require('dgram');
const fs = require('fs');
var server = dgram.createSocket('udp4');

var os = require('os');
var mysql = require('mysql');
var ifaces = os.networkInterfaces();


var PORTA_ENTRADA =1979;
var PORTA_SAIDA = 1980;
var HOST = '127.0.0.1';

var ipServidor="";
var nomeServidor="";
var pinServidor="";

const dadosdb = {
  host: "localhost",
  user: "userautohome",
  password: "UserautohomeMysql1.0bi",
  database: "autohome"
}



function execSQLQuery(sqlQry, remote_address, dadosRemoteDevice){
  const connection = mysql.createConnection(dadosdb);

  connection.query(sqlQry, function(error, results, fields){
      if(error){
        console.log(error);
      } 


      else
      {
        connection.end();
        const servidor = JSON.parse(JSON.stringify(results));
        const { nome, pin, firmware, usu_bb, se_bb, chavedispositivo, adddevicehabilitado, ip } = servidor[0];

        let dados_servidor = "";
        if (dadosRemoteDevice.tipo == "kdb"){
          dados_servidor = '{ "nome": "' + nome + '", "pin": "' + pin + '", "ip": "' + ip +  '", "firmware": "' + firmware + '"}';
          enviar_broker(remote_address, dados_servidor); 
        }
         else if ((dadosRemoteDevice.tipo == "kdbc") && (dadosRemoteDevice.pin == pin) )
         {
           if (!dadosRemoteDevice.chave)
           {
            dados_servidor = '{ "nome": "' + nome + '", "pin": "' + pin + '", "ip": "' + ip +  '", "firmware": "' + firmware + '"}';
           }
           else if (dadosRemoteDevice.chave == chavedispositivo)
           {
             if (adddevicehabilitado == "1")
             {
              dados_servidor = '{ "nome": "' + nome + '", "pin": "' + pin + '", "ip": "' + ip +  '", "firmware": "' + firmware +   '", "usermqtt": "' + usu_bb +  '", "passmqtt": "' + se_bb +'"}';
             }
             else{
              dados_servidor = '{ "nome": "' + nome + '", "pin": "' + pin + '", "ip": "' + ip +  '", "firmware": "' + firmware + '"}';
             }
            
           }
           enviar_broker(remote_address, dados_servidor);
         }
         else if ((dadosRemoteDevice.tipo == "kdbf") && adddevicehabilitado == "1")
         {
              dados_servidor = '{ "nome": "' + nome + '", "pin": "' + pin + '", "ip": "' + ip +  '", "firmware": "' + firmware +   '", "usermqtt": "' + usu_bb +  '", "passmqtt": "' + se_bb +'"}'; 
              enviar_broker(remote_address, dados_servidor);
        }
       
        
      }

  });
}



function execSQLQuery2(sqlQry){
  const connection = mysql.createConnection(dadosdb);

  connection.query(sqlQry, function(error, results, fields){
      if(error){
        console.log(error);
        process.exit(1);
      } 

      else
      {
        connection.end();
      }

  });
}




Object.keys(ifaces).forEach(function (ifname) {
  var alias = 0;

  ifaces[ifname].forEach(function (iface) {
    if ('IPv4' !== iface.family || iface.internal !== false) {
      // skip over internal (i.e. 127.0.0.1) and non-ipv4 addresses
      return;
    }

    if (alias >= 1) {
      // this single interface has multiple ipv4 addresses
      console.log(ifname + ':' + alias, iface.address);
      if (ifname  == "eth0"){
        ipServidor= iface.address
        const sqlQry2 = "UPDATE `servidor` SET `ip` = '" + ipServidor + "' WHERE `servidor`.`id` = 1";
        execSQLQuery2(sqlQry2);
      }
    } else {
      // this interface has only one ipv4 adress
      console.log(ifname, iface.address);
      if (ifname  == "eth0"){
        ipServidor= iface.address
        const sqlQry2 = "UPDATE `servidor` SET `ip` = '" + ipServidor + "' WHERE `servidor`.`id` = 1";
        execSQLQuery2(sqlQry2);
      }
    }
    ++alias;
  });
});



server.on('listening', function() {
  var address = server.address();
 console.log('UDP Server listening on ' + address.address + ':' + address.port);
});

server.on('message', function(message, remote) {



let dadosRemoteDevice = JSON.parse(message + "");

if ((dadosRemoteDevice.tipo == "kdb") || (dadosRemoteDevice.tipo == "kdbc") || (dadosRemoteDevice.tipo == "kdbf") )
{
  execSQLQuery("SELECT * FROM `servidor`", remote.address, dadosRemoteDevice);

}
 
});

server.bind(PORTA_ENTRADA);




function enviar_broker(_HOST, _PinServidor)
{
  var message = new Buffer(_PinServidor);

  var client = dgram.createSocket('udp4');
  client.send(message, 0, message.length, PORTA_SAIDA, _HOST, function(err, bytes) {
    if (err){
      throw err;
  } else{
    console.log('Mensagem Enviada para ' + _HOST +':'+ PORTA_SAIDA);
  }

    client.close();
  });
}
