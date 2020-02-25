
var NurseryTemperature = '00';

// MQTT Setup
var mqtt = require('mqtt');
console.log('Conectado para o Servidor Broker MQTT...');
var mqtt = require('mqtt');
var options = {
  port: 1883,
  host: 'localhost',
  username: 'autohome',     //muda aqui quando mudar dados de acesso
  password: 'comida05',     //muda aqui quando mudar dados de acesso
  clientId: '03AA00000001' //muda aqui para cada novo dispositivo
};
var client = mqtt.connect(options);
console.log('Sensor de Temperatura Conectado ao servidor MQTT broker');
client.subscribe('/house/temp/03AA00000001');
client.on('message', function(topic, message) {
 // console.log('Temp = ' + message);
//  console.log('Até Aqui ok');
  NurseryTemperature = message * 1;
  
  FAKE_SENSOR.randomizeTemperature(); 
  
 sensor
.getService(Service.TemperatureSensor)
.setCharacteristic(Characteristic.CurrentTemperature, FAKE_SENSOR.currentTemperature);

});

var Accessory = require('../').Accessory;
var Service = require('../').Service;
var Characteristic = require('../').Characteristic;
var uuid = require('../').uuid;

// here's a fake temperature sensor device that we'll expose to HomeKit
var FAKE_SENSOR = {
  currentTemperature: NurseryTemperature,
  getTemperature: function() { 
  //  console.log(NurseryTemperature);
    return FAKE_SENSOR.currentTemperature;
  },
  randomizeTemperature: function() {
    // randomize temperature to a value between 0 and 100
    FAKE_SENSOR.currentTemperature = NurseryTemperature;
 //   console.log(NurseryTemperature);
    
  }
}


// Generate a consistent UUID for our Temperature Sensor Accessory that will remain the same
// even when restarting our server. We use the `uuid.generate` helper function to create
// a deterministic UUID based on an arbitrary 'namespace' and the string 'temperature-sensor'.
var sensorUUID = uuid.generate('hap-nodejs:accessories:TempDocker');

// This is the Accessory that we'll return to HAP-NodeJS that represents our fake lock.
var sensor = exports.accessory = new Accessory('Temp Docker', sensorUUID);

// Add properties for publishing (in case we're using Core.js and not BridgedCore.js)
sensor.username = '03:AA:00:00:00:01:D5:B1';
sensor.pincode = '291-65-798';

sensor
  .getService(Service.AccessoryInformation)
  .setCharacteristic(Characteristic.Manufacturer, 'AutoHome')
  .setCharacteristic(Characteristic.Model, '001')
  .setCharacteristic(Characteristic.SerialNumber, 'A10001');

// Add the actual TemperatureSensor Service.
// We can see the complete list of Services and Characteristics in `lib/gen/HomeKitTypes.js`
sensor
  .addService(Service.TemperatureSensor)
  .getCharacteristic(Characteristic.CurrentTemperature)
  .on('get', function(callback) {
    
    // return our current value
    callback(null, FAKE_SENSOR.getTemperature());
  });

// randomize our temperature reading every 3 seconds
