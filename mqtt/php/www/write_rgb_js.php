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
var lightState = 0;


////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
var name = '{$namehomekit}';                                       //Name to Show to IOS
var UUID = 'hap-nodejs:accessories:{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';     //Change the RGBLight to something unique for each light - this should be unique for each node on your system
var USERNAME = '{$usernamehomekit}:{$aleatorio_username1}:{$aleatorio_username2}';              //This must also be unique for each node - make sure you change it!

var MQTT_IP = 'localhost'
var lightTopic = '{$topico1}'
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////
////////////////CHANGE THESE SETTINGS TO MATCH YOUR SETUP BEFORE RUNNING!!!!!!!!!!!!!//////////////////////////


// MQTT Setup
var mqtt = require('mqtt');
var options = {
  port: 1883,
  host: 'localhost',
  username: '{$username_mqtt}',     //muda aqui quando mudar dados de acesso
  password: '{$password_mqtt}',     //muda aqui quando mudar dados de acesso
  clientId: '{$clientId}'  //muda aqui para cada novo dispositivo
};
var client = mqtt.connect(options);
client.on('message', function(topic, message) {

});

//setup HK light object
var lightUUID = uuid.generate(UUID);
var light = exports.accessory = new Accessory(name, lightUUID);

// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
light.username = USERNAME;
light.pincode = '{$pincodehomekit}';

//add a light service and setup the On Characteristic
light
  .addService(Service.Lightbulb)
  .getCharacteristic(Characteristic.On)
  .on('get', function(callback) {
    callback(null, lightAction.getState());
  });

  light
  .getService(Service.Lightbulb)
  .getCharacteristic(Characteristic.On)
  .on('set', function(value, callback) {
    lightAction.setState(value);
    callback();
  });

//Add and setup Brightness
  light
  .getService(Service.Lightbulb)
  .addCharacteristic(Characteristic.Brightness)
  .on('set', function(value, callback){
    lightAction.setBrightness(value);
    callback()
  });

light
  .getService(Service.Lightbulb)
  .getCharacteristic(Characteristic.Brightness)
  .on('get', function(callback){
    callback(null, lightAction.getBrightness())
  });

//Add and setup Saturation
  light
  .getService(Service.Lightbulb)
  .addCharacteristic(Characteristic.Saturation)
  .on('set', function(value, callback){
    lightAction.setSaturation(value);
    callback()
  });

light
  .getService(Service.Lightbulb)
  .getCharacteristic(Characteristic.Saturation)
  .on('get', function(callback){
    callback(null, lightAction.getSaturation())
  });

//Add and setup Hue
light
  .getService(Service.Lightbulb)
  .addCharacteristic(Characteristic.Hue)
  .on('set', function(value, callback){
    lightAction.setHue(value);
    callback()
  });

light
  .getService(Service.Lightbulb)
  .getCharacteristic(Characteristic.Hue)
  .on('get', function(callback){
    callback(null, lightAction.getHue())
  });



// here's a fake temperature sensor device that we'll expose to HomeKit
var lightAction = {

  //initialize the various state variables
  currentState: 0,
  currentBrightness: 0,
  currentHue: 0,
  currentSaturation: 0,

  lastBrightness: 0,
  lastHue: 0,
  lastSaturation: 0,


  //On Characteristic set/get
  getState: function() { return this.currentState;},
  setState: function(newState){

    if((newState == true && this.currentState == 0) || (newState == false && this.currentState == 1) ){
      console.log('Setting new outlet state: ' + newState.toString());
      if(newState == true){
        client.publish(lightTopic, 'p1');
        this.currentState = 1;
      }
      else{
        client.publish(lightTopic, 'p0');
        this.currentState = 0;
      }
    }

  },

  //Brightness Characteristic set/get
  getBrightness: function(){return this.currentBrightness;},
  setBrightness: function(newBrightness){
    this.currentBrightness = newBrightness;
    this.updateLight();
  },


  //Saturation Characteristic set/get
  getSaturation: function(){return this.currentSaturation;},
  setSaturation: function(newSaturation){
    this.currentSaturation = newSaturation;
    this.updateLight();
  },


  //Hue Characteristic set/get
  getHue: function(){return this.currentHue;},
  setHue: function(newHue){
    this.currentHue = newHue;
    this.updateLight();
  },


  //other light setting functions
  updateState: function() {
    this.currentState = lightState;
  },

  updateLight: function(){
    if(this.lastSaturation != this.currentSaturation || this.lastHue != this.currentHue || this.lastBrightness != this.currentBrightness){
      pubBrightness = this.currentBrightness / 100;
      pubHue = this.currentHue / 360;
      pubSaturation = this.currentSaturation / 100;
      toPublish = 'h' + pubHue.toFixed(3).toString() + ',' + pubSaturation.toFixed(3).toString() + ',' + pubBrightness.toFixed(3).toString()
      client.publish(lightTopic, toPublish);

      this.lastBrightness = this.currentBrightness;
      this.lastHue = this.currentHue;
      this.lastSaturation = this.currentSaturation;
    }
  }
  
}



// update the characteristic values so interested iOS devices can get notified
setInterval(function() {
  light
    .getService(Service.Lightbulb)
    .setCharacteristic(Characteristic.On, lightAction.currentState);
  light
    .getService(Service.Lightbulb)
    .setCharacteristic(Characteristic.Brightness, lightAction.getBrightness());
  light
    .getService(Service.Lightbulb)
    .setCharacteristic(Characteristic.Hue, lightAction.getHue());
  light
    .getService(Service.Lightbulb)
    .setCharacteristic(Characteristic.Saturation, lightAction.getSaturation());

}, 2000);";


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
