    
	function prepara_mqtt(comando_mqtt, _topico)
	{
	var senha_dispositivo = $("#senha_dispositivo").val();
	var parametro_dispositivo = $("#parametro").val();
	var mensagem_mqqt = "";
			
		if (comando_mqtt == "01")
		{
			 mensagem_mqqt = "AT" + senha_dispositivo + "CWJAP=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "02")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MQTTUSER=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "03")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MQTTPORT=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "04")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MQTTSER=" + parametro_dispositivo + "#";  // CHECA IP DO DISPOSITIVO
		}else if (comando_mqtt == "05")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MQTTSER#";
		}else if (comando_mqtt == "06")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "SN=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "07")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "OTA=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "08")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "OTA#";
		}else if (comando_mqtt == "09")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "ALEXA=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "10")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "NOMEALEXA=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "11")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "NOMEALEXA#";
		}else if (comando_mqtt == "12")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "PRIMEIROUSO=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "13")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "PRIMEIROUSO#";
		}else if (comando_mqtt == "14")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "SENHADIS=" + parametro_dispositivo + "#";
		}else if (comando_mqtt == "15")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MQTT#";
		}else if (comando_mqtt == "16")  // Reset da Persiana
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "RESET#";
		}else if (comando_mqtt == "17")
		{
			mensagem_mqqt = "1";  // Liga Dispositivo
		}else if (comando_mqtt == "18")
		{
			mensagem_mqqt = "0";  // Liga Dispositivo
		}else if (comando_mqtt == "19")  // Home da Persiana
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "HOME#";
		}
		else if (comando_mqtt == "20")  // Subir Persiana
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "UP#";
		}
		else if (comando_mqtt == "21")  // Descer Persiana
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "DOWN#";
		}
		else if (comando_mqtt == "22")  //Abrir Persiana
		{
			mensagem_mqqt = "P100";  
		}
		else if (comando_mqtt == "23")  // Para Persiana
		{
			mensagem_mqqt = "P101";  
		}
		else if (comando_mqtt == "24") // Fechar Persiana
		{
			mensagem_mqqt = "P000";  
		}
		else if (comando_mqtt == "25")  // INVERTER PESIANA
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "INVERT#";
		}
		else if (comando_mqtt == "26")   // ABRIR PARA FECHAR MOTOT
		{
			mensagem_mqqt = "P102"; 
		}
		else if (comando_mqtt == "27")   // INVERTER SENSOR
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "INVERTSENSOR#";
		}else if (comando_mqtt == "28")  // SETA IP DISPOSITIVO
		{
		//	mensagem_mqqt = "AT" + senha_dispositivo + "CIFSR=" + parametro_dispositivo + "#";  // CHECA IP DO DISPOSITIVO  NÃO EXITE
		}else if (comando_mqtt == "29")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "CIFSR#";
		}else if (comando_mqtt == "30")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MODOINIT=" + parametro_dispositivo + "#";  // CHECA IP DO DISPOSITIVO
		}else if (comando_mqtt == "31")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "MODOINIT#";
		}else if (comando_mqtt == "32")
		{
			mensagem_mqqt = "AT" + senha_dispositivo + "PARAM#";   // CHECA PARAMETRO DA PERSIANA
		}
		else if (comando_mqtt == "33")
		{
		//	mensagem_mqqt = "AT" + senha_dispositivo + "PARAM#";   // CHECA PARAMETRO DA PERSIANA
		}
		
		pubmqtt(mensagem_mqqt, _topico, "1");
	}
	
		function pubmqtt(mensagem, topico, reter)
			{


				 $.post('../pub.php',{mensagem: mensagem, topico: topico, reter: reter},function(data){}) 
			}
			
			