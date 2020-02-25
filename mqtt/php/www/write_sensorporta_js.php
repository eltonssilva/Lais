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




$txt = "var Accessory = require('../').Accessory;
var Service = require('../').Service;
var Characteristic = require('../').Characteristic;
var uuid = require('../').uuid;
const StringDecoder = require('string_decoder').StringDecoder;
const decoder = new StringDecoder('utf8');

var lastState = false;

const mqtt = require('mqtt');
const mqttOptions = {
  port: {$port},
  host: '{$host}',
  username: '{$username_mqtt}',     //muda aqui quando mudar dados de acesso
  password: '{$password_mqtt}',     //muda aqui quando mudar dados de acesso
  clientId: '{$clientId}' //muda aqui para cada novo dispositivo
};
const mqttClient = mqtt.connect(mqttOptions);

mqttClient.on('error', function(err) {
  console.log(err);
});

mqttClient.on('connect', () => {
  mqttClient.subscribe('{$topico1}'); //receive the contact state message

})

mqttClient.on('message', (topic, message) => {
  console.log('receied message %s %s', topic, message)
      return handleContactRequest(message)
})

function handleTelemetry (message) {
	console.log(timeDate + ' received telementry'); //Sensor is still alive!
}

function handleContactRequest (message) {
  
  if (message == '1') {
    timeDate = getTimeDate();
    console.log(timeDate + ' Contact status: OPENED');
    CONTACT_SENSOR.currentContactState = true;
    sensor
      .getService(Service.ContactSensor)
      .setCharacteristic(Characteristic.ContactSensorState, CONTACT_SENSOR.currentContactState);
    lastState = CONTACT_SENSOR.currentContactState;

  }

  if (message == '0'){
    timeDate = getTimeDate();
    console.log(timeDate + ' Contact status: CLOSED');
    CONTACT_SENSOR.currentContactState = false;
    sensor
      .getService(Service.ContactSensor)
      .setCharacteristic(Characteristic.ContactSensorState, CONTACT_SENSOR.currentContactState);
    lastState = CONTACT_SENSOR.currentContactState;

  }
}


// here's a fake temperature sensor device that we'll expose to HomeKit
var CONTACT_SENSOR = {
  currentContactState: false,

  getContactState: function() { 
    contactState = CONTACT_SENSOR.currentContactState;
    timeDate = getTimeDate();

    if (contactState == true){
      console.log(timeDate + ' Getting the Sensor State: OPENED');
    } else {
      console.log(timeDate + ' Getting the Sensor State: CLOSED');
    }
    
    return contactState
  }
}


// Generate a consistent UUID for our Temperature Sensor Accessory that will remain the same
// even when restarting our server. We use the `uuid.generate` helper function to create
// a deterministic UUID based on an arbitrary 'namespace' and the string 'temperature-sensor'.
var sensorUUID = uuid.generate('hap-nodejs:accessories:{$outronamehomekit}');

// This is the Accessory that we'll return to HAP-NodeJS that represents our fake lock.
var sensor = exports.accessory = new Accessory('{$namehomekit}', sensorUUID);

// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
sensor.username = '{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';
sensor.pincode = '{$pincodehomekit}';
sensor.category = 10;

sensor
  .getService(Service.AccessoryInformation)
  .setCharacteristic(Characteristic.Manufacturer, '{$fabricante}')
  .setCharacteristic(Characteristic.Model, '{$modelo}')
  .setCharacteristic(Characteristic.SerialNumber, '{$clientId}');


// Add the actual HumiditySensor Service.
// We can see the complete list of Services and Characteristics in `lib/gen/HomeKitTypes.js`
sensor
  .addService(Service.ContactSensor)
  .getCharacteristic(Characteristic.ContactSensorState)
  .on('get', function(callback) {
    
    // return our current value
    callback(null, CONTACT_SENSOR.getContactState());
  });

function getTimeDate(){
  d = new Date();
  return d.toLocaleString();
}";


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