//var mqttConnection = require('../../config/mqttConnection');
//const mqttGridgeSub = require('../../app/mqttGbridge/mqttGridgeSub');
//var ClienteMQTTGbridge = mqttConnection.MqttBridge();

module.exports = function (user_gbridge, topico, carga, ClienteMQTTGbridge)
{
var codigo_dispositivo;
var sub_topico;
var carga_publica;
var topico_publica;


traco_1 = topico.indexOf("/" , 1); 
traco_2 = topico.indexOf("/" , traco_1+1); 
traco_3 = topico.indexOf("/" , traco_2+1);

sub_topico =  topico.substring(traco_1+1, traco_2); 
codigo_dispositivo = topico.substring(traco_2 + 1);


    if (sub_topico == "confirma")
    {
    topico_publica = "gBridge/" + user_gbridge + "/confirma/" + codigo_dispositivo;

    var  tipogeral = codigo_dispositivo.substring(0,2);
        if (tipogeral == '01')
        {
            if (carga == 'On')
        {
            carga = '1';
        }
        
            if (carga == 'Off')
        {
            carga = '0';
        }
        }
    carga_publica =  carga;  
  //  console.log (topico_publica + " " + carga_publica);
    ClienteMQTTGbridge.publish(topico_publica, carga_publica);

    }
    else if (sub_topico == "ifredarc")
    {
    topico_publica = "gBridge/" + user_gbridge + "/confirma/" + codigo_dispositivo;

        if (carga == 'XX!000!TON')
        {
            carga = 'on';
        }
        
            if (carga == 'XX!000!TOFF')
        {
            carga = 'off';
        }
        
    carga_publica =  carga;  
 //   console.log (topico_publica + " " + carga_publica);
    ClienteMQTTGbridge.publish(topico_publica, carga_publica);
    }


}