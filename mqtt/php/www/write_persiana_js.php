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




$txt = "var Accessory = require('../').Accessory;
var Service = require('../').Service;
var Characteristic = require('../').Characteristic;
var uuid = require('../').uuid;


////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
var name = '{$namehomekit}';                                       //Name to Show to IOS
var UUID = 'hap-nodejs:accessories:{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';     //Change the RGBLight to something unique for each light - this should be unique for each node on your system
var USERNAME = '{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';             //This must also be unique for each node - make sure you change it!
var posicao=0;
var posicao_ant=0;

var MQTT_IP = 'localhost';
var PersianaTopico = '{$topico1}';
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////


// MQTT Setup
var mqtt = require('mqtt');
var options = {
  port: {$port},
  host: '{$host}',
  username: '{$username_mqtt}',     //muda aqui quando mudar dados de acesso
  password: '{$password_mqtt}',     //muda aqui quando mudar dados de acesso
  clientId: '{$clientId}'  //muda aqui para cada novo dispositivo
};
var client = mqtt.connect(options);

console.log('Persiana Conectado para MQTT broker');
client.subscribe('{$topicosub1}');

client.on('message', function(topic, message) {
	
	  console.log('Pos = ' + message);
  

    	PersianaAction.currentPosition = message;
    	posicao = parseInt(message);
    Persiana
      .getService(Service.WindowCovering)
		.updateCharacteristic(Characteristic.CurrentPosition, posicao)
		.updateCharacteristic(Characteristic.PositionState, 2);
	
	
  if (posicao_ant != posicao)
  	{
  	 posicao_ant = posicao;
  	Persiana
      .getService(Service.WindowCovering)
		.updateCharacteristic(Characteristic.CurrentPosition, posicao)
		.updateCharacteristic(Characteristic.PositionState, 2);
  			
	}


});

//setup HK light object
var lightUUID = uuid.generate(UUID);
var Persiana = exports.accessory = new Accessory(name, lightUUID);

// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
Persiana.username = USERNAME;
Persiana.pincode = '{$pincodehomekit}';

Persiana
  .getService(Service.AccessoryInformation)
  .setCharacteristic(Characteristic.Manufacturer, 'AutoHome')
  .setCharacteristic(Characteristic.Model, '{$modelo}')
  .setCharacteristic(Characteristic.SerialNumber, '{$numeroserial}');

//add a light service and setup the On Characteristic
Persiana
  .addService(Service.WindowCovering)
  .getCharacteristic(Characteristic.TargetPosition)
  .on('get', function(callback) {
    callback(null, posicao);
  });

  Persiana
  .getService(Service.WindowCovering)
  .getCharacteristic(Characteristic.TargetPosition)
  .on('set', function(value, callback) {
    PersianaAction.setState(value);
    callback();
  });




// here's a fake temperature sensor device that we'll expose to HomeKit
var PersianaAction = {

  //initialize the various state variables
   //initialize the various state variables
  currentPosition: 0,
  targetPosition: 0,
  positionState: 0,
  lastPosition: 0,

  //On Characteristic set/get
  getState: function() { return this.targetPosition;},
  setState: function(newState){
  	
  	 if(newState.toString() != this.targetPosition)
  	 {
  	 	  	var r = newState.toString();
   
			posicao_ant = r;
			
    		if (r.length == 1 )  // Corrigindo Tamanho da string no braço
			{
			r = 'P00' + r;
			}

			if (r.length == 2 )  // Corrigindo Tamanho da string no braço
			{
			r = 'P0' + r;
			}
	
			if (r.length == 3 )  // Corrigindo Tamanho da string no braço
			{
			r = 'P' + r;
			}
	
  			client.publish(PersianaTopico, r);
			this.targetPosition = newState.toString();
  	 }

  }
  
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
        $consoantes .= '0123456789';$aleatorio_username1 = gerarSenha(2, 0);
$aleatorio_username2 = gerarSenha(2, 0);
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


