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




$txt = "
var NurseryRelativeHumidity = '00';

// MQTT Setup
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
console.log('Sensor de Umidade Conectado ao servidor MQTT broker');
client.subscribe('{$topico1}');
client.on('message', function(topic, message) {
 // console.log('Temp = ' + message);
//  console.log('Até Aqui ok');
  NurseryRelativeHumidity = message * 1;
  
  FAKE_SENSOR.randomizeRelativeHumidity(); 
  
 sensor
.getService(Service.HumiditySensor)
.setCharacteristic(Characteristic.CurrentRelativeHumidity, FAKE_SENSOR.CurrentRelativeHumidity);

});

var Accessory = require('../').Accessory;
var Service = require('../').Service;
var Characteristic = require('../').Characteristic;
var uuid = require('../').uuid;

// here's a fake RelativeHumidity sensor device that we'll expose to HomeKit
var FAKE_SENSOR = {
  CurrentRelativeHumidity: NurseryRelativeHumidity,
  getRelativeHumidity: function() { 
  //  console.log(NurseryRelativeHumidity);
    return FAKE_SENSOR.CurrentRelativeHumidity;
  },
  randomizeRelativeHumidity: function() {
    // randomize RelativeHumidity to a value between 0 and 100
    FAKE_SENSOR.CurrentRelativeHumidity = NurseryRelativeHumidity;
 //   console.log(NurseryRelativeHumidity);
    
  }
}


// Generate a consistent UUID for our RelativeHumidity Sensor Accessory that will remain the same
// even when restarting our server. We use the `uuid.generate` helper function to create
// a deterministic UUID based on an arbitrary 'namespace' and the string 'RelativeHumidity-sensor'.
var sensorUUID = uuid.generate('hap-nodejs:accessories:{$outronamehomekit}');

// This is the Accessory that we'll return to HAP-NodeJS that represents our fake lock.
var sensor = exports.accessory = new Accessory('{$namehomekit}', sensorUUID);

// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
sensor.username = '{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';
sensor.pincode = '{$pincodehomekit}';

sensor
  .getService(Service.AccessoryInformation)
  .setCharacteristic(Characteristic.Manufacturer, '{$fabricante}')
  .setCharacteristic(Characteristic.Model, '{$modelo}')
  .setCharacteristic(Characteristic.SerialNumber, '{$numeroserial}');

// Add the actual HumiditySensor Service.
// We can see the complete list of Services and Characteristics in `lib/gen/HomeKitTypes.js`
sensor
  .addService(Service.HumiditySensor)
  .getCharacteristic(Characteristic.CurrentRelativeHumidity)
  .on('get', function(callback) {
    
    // return our current value
    callback(null, FAKE_SENSOR.getRelativeHumidity());
  });

// randomize our RelativeHumidity reading every 3 seconds
";

  
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