// MQTT Setup
var mqtt = require('mqtt');
module.exports = {
    MqttLocal: function(username, password, pin)
    {
      var options = 
        {
            port: 1883,
            //host: '192.168.10.101',
            host: 'mqttautodomo',
            username: username,     //muda aqui quando mudar dados de acesso
            password: password,     //muda aqui quando mudar dados de acesso
            clientId: pin + Math.random().toString(16).substr(2, 8)  //muda aqui para cada novo dispositivo
        };
      
    //    console.log(options);
    var client = mqtt.connect(options);
    return client;
    },

  MqttBridge: function(username, password, pin)
  {
    
  var options = 
    {
        port: 1883,
        host: 'mqtt.homegbridge.com',
        qos: 2,
       'username':username,     //muda aqui quando mudar dados de acesso
        password: password,     //muda aqui quando mudar dados de acesso
        clientId: pin + Math.random().toString(16).substr(2, 8)  //muda aqui para cada novo dispositivo
    };
  //  console.log(options);
  var client = mqtt.connect(options);
  return client;
  },


}


