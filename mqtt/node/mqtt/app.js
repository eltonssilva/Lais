var app = require('./config/server');
var mqttConnection = require('./config/mqttConnection');
const mqttGridgeSub = require('./app/mqttGbridge/mqttGridgeSub');
const mqttGridgePub = require('./app/mqttGbridge/mqttGridgePub');

var dbconnection = require('./config/dbConnection');
var connection = dbconnection.dbproducao();






var PinServidor="";
var user_gbridge="";
var usermqtt_gh="";
var senhamqtt_gh = "";
var usu_bb ="";
var se_bb = "";


  //   servidorModel(connection, function(error, result)
	 connection.query('SELECT * FROM `servidor`', function(error, result)
		{
			if (error) throw error;
			console.log(result[0].id);
			PinServidor = result[0].pin;
			user_gbridge = result[0].user_gbridge;
			usermqtt_gh = result[0].usermqtt_gh;
			senhamqtt_gh = result[0].senhamqtt_gh;
			usu_bb = result[0].usu_bb;
			se_bb = result[0].se_bb;
			console.log("PinServidor=", PinServidor);
	
			var ClienteMQTTLocal = mqttConnection.MqttLocal(usu_bb, se_bb, PinServidor);
	    var ClienteMQTTGbridge = mqttConnection.MqttBridge(usermqtt_gh, senhamqtt_gh, PinServidor);

			ClienteMQTTGbridge.on('connect', function() 
			{ // When connected
				console.log("Conectado Gbridge");
				var topico ='gBridge/' + user_gbridge + '/#';
				console.log(topico);
				ClienteMQTTGbridge.subscribe(topico);
				ClienteMQTTGbridge.on('message', function(topic, message) 
				{
					console.log("Gbridge-" + message.toString());
					console.log("Gbridge-" + topic.toString());
					var mqttsub = mqttGridgeSub(topic.toString(), message.toString());

					var topico = mqttsub.topico;
					var carga = mqttsub.mensagem;
					if (typeof(topico) !== 'undefined') 
					{
						var partesTopico = topico.split("/");
						if (partesTopico[2] != 'confirma')
						{
							ClienteMQTTLocal.publish(topico, carga);
						}
												
					}


				});
		});

		ClienteMQTTGbridge.on('error', function(err) {
			console.log("ErroGbridge:" + err);
		});



ClienteMQTTLocal.on('connect', function() 
{ // When connected
	console.log("Conectado Local");
	ClienteMQTTLocal.subscribe('/house/#');
	ClienteMQTTLocal.on('message', function(topic, message) 
	{
		console.log("Local-" + message.toString());
		console.log("Local-" + topic.toString());
		var mqttpub = mqttGridgePub(user_gbridge, topic.toString(), message.toString(), ClienteMQTTGbridge);

	});
});

ClienteMQTTLocal.on('error', function(err) {
	console.log("ErroLocal:" + err);
});



});