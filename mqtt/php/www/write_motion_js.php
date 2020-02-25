 <?php
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança

$usernamehomekit = $_POST['username_iphone'];
$pincodehomekit = $_POST['pin_iphone'];  
$file_name = str_replace(":","",$usernamehomekit) . "_accessory.js";
$topico1 =  $_POST['setPubTopic0'];
$topicosub1 = $_POST['setSubTopic0'];
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




$txt = "
// MQTT Setup
var mqtt = require('mqtt');
console.log('Conectado para o Servidor Broker MQTT...');
var mqtt = require('mqtt');
var options = {
  port: {$port},
  host: '{$host}',
  username: '{$username_mqtt}',     //muda aqui quando mudar dados de acesso
  password: '{$password_mqtt}',     //muda aqui quando mudar dados de acesso
  clientId: '{$clientId}'  //muda aqui para cada novo dispositivo
};
var client = mqtt.connect(options);
console.log('Dispositivo Conectado para MQTT broker');

client.subscribe('{$topicosub1}');
client.on('message', function(topic, message) {
  console.log('Temp = ' + message);
  
  
    if (message == '1') {
    	MOTION_SENSOR.motionDetected = true;
    motionSensor
      .getService(Service.MotionSensor)
		.updateCharacteristic(Characteristic.MotionDetected, true);
      console.log('on');
   	}
    else {
      MOTION_SENSOR.motionDetected = false;
	motionSensor
      .getService(Service.MotionSensor)
		.updateCharacteristic(Characteristic.MotionDetected, false);
      console.log('false');
   };


});



var Accessory = require('../').Accessory;
var Service = require('../').Service;
var Characteristic = require('../').Characteristic;
var uuid = require('../').uuid;

////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
var name = '{$namehomekit}';                                       //Name to Show to IOS
var UUID = 'hap-nodejs:accessories:{$outronamehomekit}';     //Change the RGBLight to something unique for each light - this should be unique for each node on your system
var USERNAME = '{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';            //This must also be unique for each node - make sure you change it!

var MQTT_IP = 'localhost';
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////


// here's a fake hardware device that we'll expose to HomeKit
var MOTION_SENSOR = {
  motionDetected: false,

  getStatus: function() {
    //set the boolean here, this will be returned to the device
    MOTION_SENSOR.motionDetected = false;
  },
  identify: function() {
    console.log('Identify the motion sensor!');
  }
}

// Generate a consistent UUID for our Motion Sensor Accessory that will remain the same even when
// restarting our server. We use the `uuid.generate` helper function to create a deterministic
// UUID based on an arbitrary 'namespace' and the word 'motionsensor'.
var motionSensorUUID = uuid.generate(UUID);

// This is the Accessory that we'll return to HAP-NodeJS that represents our fake motionSensor.
var motionSensor = exports.accessory = new Accessory(name, motionSensorUUID);

// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
motionSensor.username = USERNAME;
motionSensor.pincode = '{$pincodehomekit}';

// set some basic properties (these values are arbitrary and setting them is optional)
motionSensor
  .getService(Service.AccessoryInformation)
  .setCharacteristic(Characteristic.Manufacturer, 'AutoHome')
  .setCharacteristic(Characteristic.Model, '{$modelo}')
  .setCharacteristic(Characteristic.SerialNumber, '{$numeroserial}');;

// listen for the 'identify' event for this Accessory
motionSensor.on('identify', function(paired, callback) {
  MOTION_SENSOR.identify();
  callback(); // success
});

motionSensor
  .addService(Service.MotionSensor, name) // services exposed to the user should have 'names' like 'Fake Motion Sensor' for us
  .getCharacteristic(Characteristic.MotionDetected)
  .on('get', function(callback) {
     MOTION_SENSOR.getStatus();
     callback(null, Boolean(MOTION_SENSOR.motionDetected));
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
