 <?php
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança

$usernamehomekit = $_POST['username_iphone'];
$pincodehomekit = $_POST['pin_iphone'];  
$file_name = str_replace(":","",$usernamehomekit) . "_accessory.js";
$topico1 =  $_POST['setSubTopic0'];
$topicosub1 = $_POST['setSubTopic0_confirma'];
$clientId = str_replace(":","",$usernamehomekit);
$namehomekit = $_POST['Descricao']; 
$outronamehomekit = str_replace(" ","",$namehomekit);
$modelo = '001';
$numeroserial = 'A10001';
$publishValue = $_POST['publishValue'];
$publishValue2 = $_POST['publishValue2'];
$username_mqtt = '';
$password_mqtt = '';
$aleatorio_username1 = gerarSenha(2, 0);
$aleatorio_username2 = gerarSenha(2, 0);

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "SELECT usu_bb, se_bb FROM `servidor`";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);

mysqli_close($con);
while($rec = mysqli_fetch_array($data)) 
{ 
$username_mqtt = $rec['usu_bb'];
$password_mqtt = $rec['se_bb'];
}


// $endereco = '/home/pi/HAP-NodeJS/teste';
 
echo $endereco . $file_name;
$myfile = fopen($endereco . $file_name, 'w') or die('Unable to open file!');//
//$txt = 'Elton Doe\n';
//fwrite($myfile, $txt);
//$txt .= 'Jane Doe\n';
//echo $txt;




$txt = "// MQTT Setup
var mqtt = require('mqtt');
console.log('Conectado para o Servidor Broker MQTT...');
var mqtt = require('mqtt');
var options = {
  port: {$port},
  host: '{$host}',
  username: '{$username_mqtt}',     //muda aqui quando mudar dados de acesso
  password: '{$password_mqtt}',     //muda aqui quando mudar dados de acesso
  clientId: '{$clientId}' //muda aqui para cada novo dispositivo
};
var client = mqtt.connect(options);
console.log('Dispositivo Conectado para MQTT broker');

client.subscribe('{$topicosub1}');
client.on('message', function(topic, message) {
  console.log('Temp = ' + message);
  
  
    if (message == 'On') {
    	LAMPADA_AUTOHOME.powerOn = true;
    light
      .getService(Service.Switch)
		.updateCharacteristic(Characteristic.On, true);
      console.log('on');
   	}
    else {
      LAMPADA_AUTOHOME.powerOn = false;
	light
      .getService(Service.Switch)
		.updateCharacteristic(Characteristic.On, false);
      console.log('false');
   };


});

var Accessory = require('../').Accessory;
var Service = require('../').Service;
var Characteristic = require('../').Characteristic;
var uuid = require('../').uuid;

// here's a fake hardware device that we'll expose to HomeKit
var LAMPADA_AUTOHOME = {
  powerOn: false,

  setPowerOn: function(on) {
    console.log('Atuando Dispositvo %s!', on ? '{$publishValue}' : '{$publishValue2}');
    if (on) {
      client.publish('{$topico1}', '{$publishValue}', {retain: true});   //Topico a Ser alterado
      LAMPADA_AUTOHOME.powerOn = on;
   	}
    else {
	    client.publish('{$topico1}','{$publishValue2}', {retain: true});   //Topico a ser alterado
      LAMPADA_AUTOHOME.powerOn = false;
   };

  },
  identify: function() {
    console.log('Identificando o Dispositivo!');
  }
}

// Generate a consistent UUID for our light Accessory that will remain the same even when
// restarting our server. We use the `uuid.generate` helper function to create a deterministic
// UUID based on an arbitrary 'namespace' and the word 'Christmaslight'.
var lightUUID = uuid.generate('hap-nodejs:accessories:{$outronamehomekit}');

// This is the Accessory that we'll return to HAP-NodeJS that represents our fake light.
var light = exports.accessory = new Accessory('{$namehomekit}', lightUUID);


// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
light.username = '{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';
light.pincode = '{$pincodehomekit}';

// set some basic properties (these values are arbitrary and setting them is optional)
light
  .getService(Service.AccessoryInformation)
  .setCharacteristic(Characteristic.Manufacturer, '{$fabricante}')
  .setCharacteristic(Characteristic.Model, '{$modelo}')
  .setCharacteristic(Characteristic.SerialNumber, '{$numeroserial}');

// listen for the 'identify' event for this Accessory
light.on('identify', function(paired, callback) {
  LAMPADA_AUTOHOME.identify();
  callback(); // success
});

// Add the actual Lightbulb Service and listen for change events from iOS.
// We can see the complete list of Services and Characteristics in `lib/gen/HomeKitTypes.js`
light
  .addService(Service.Switch, '{$namehomekit}') // services exposed to the user should have 'names' like 'Fake Light' for us
  .getCharacteristic(Characteristic.On)
  .on('set', function(value, callback) {
    LAMPADA_AUTOHOME.setPowerOn(value);
    callback(); // Our fake Light is synchronous - this value has been successfully set
  });

// We want to intercept requests for our current power state so we can query the hardware itself instead of
// allowing HAP-NodeJS to return the cached Characteristic.value.
light
  .getService(Service.Switch)
  .getCharacteristic(Characteristic.On)
  .on('get', function(callback) {

    // this event is emitted when you ask Siri directly whether your light is on or not. you might query
    // the light hardware itself to find this out, then call the callback. But if you take longer than a
    // few seconds to respond, Siri will give up.
    
    var err = null; // in case there were any problems

    if (LAMPADA_AUTOHOME.powerOn) {
//      console.log('Ligar lampada ? Sim.');
      callback(err, true);
    }
    else {
 //     console.log('Desligar Lampada? Nao.');
      callback(err, false);
    }
  });";
  
fwrite($myfile, $txt);
fclose($myfile);

function gerarSenha($tamanho=2, $forca=0) {
    $vogais = '0123456789AE';
    $consoantes = 'BCDF';
    if ($forca >= 1) {
        $consoantes .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($forca >= 2) {
        $vogais .= "AEIOUY";
    }
    if ($forca >= 4) {
        $consoantes .= '0123456789';
    }
    if ($forca >= 8 ) {
        $vogais .= 'LMY0';
    }
 
    $senha = '';
    $alt = time() % 2;
    for ($i = 0; $i < $tamanho; $i++) {
        if ($alt == 1) {
            $senha .= $consoantes[(rand() % strlen($consoantes))];
            $alt = 0;
        } else {
            $senha .= $vogais[(rand() % strlen($vogais))];
            $alt = 1;
        }
    }
    return $senha;
}

?> 