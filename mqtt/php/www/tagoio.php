<?php
require_once("usuario/dados_bd.php");
error_reporting(0);


function Get_Token_tago()
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		
		$query = "SELECT apikey_gh FROM `servidor`";
		
		mysqli_set_charset($cnx, 'utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);

		return $data;
}




function Get_BearerToken_NoreRed_tago()
{

  $endereco = $_SERVER[HTTP_HOST];
  $arr = array(
  'client_id' => 'node-red-admin', 
  'grant_type' => 'password',
  'scope' => '*',
  'username' => 'admin',
  'password' => 'comida05'
  );

  $data =  json_encode($arr);
  //echo $data . "<br>";
//$APYKEY = 'QyJmXq3XmgnJABkg:U0oxdGet_Devices()WhwS092QVFtV3NCazhkc2gxd1lCVGo3dWVyR002aUFnRHlDUTY0VjJVYkh5YWtKUXYxNVVuUnEwdGh6MktaRVVRaHFLUmNLS21PQ2pTOWRpWlFxNWtKSUtpRExZQVlWNGYxb3p6c1RVTXFCR3FzVFI5aTlUWDNUWjl6eDk=';
$url = "http://{$endereco}:1880/auth/token";

// use key 'http' even if you send the request to https://...
	$options = array(
    'http' => array(
        'header' => 'Authorization: Bearer '. ''  . "\r\n"  . 
        "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => $data
    	)
	);
    $context  = stream_context_create($options);
	 $result = file_get_contents($url, false, $context);
   $Jsonresult = json_decode($result);
	 return  $Jsonresult->{'access_token'};
//	if ($result === FALSE) { echo "Erro"; }
}

function getFluxoTagoIO(){
  $access_token = Get_BearerToken_NoreRed_tago();;

  $endereco = $_SERVER[HTTP_HOST];
  $idfluxo = '827f49e3.691098';

  $url = "http://{$endereco}:1880/flow/{$idfluxo}";

  // use key 'http' even if you send the request to https://...
	$options = array(
    'http' => array(
        'header' => 'Authorization: Bearer '. $access_token  . "\r\n"  . 
        "Content-Type: application/json\r\n",
        'method'  => 'GET',

    	)
	);
    $context  = stream_context_create($options);
	 $result = file_get_contents($url, false, $context);
   //$Jsonresult = json_decode($result);
	 return  json_decode($result);
//	if ($result === FALSE) { echo "Erro"; }

}

function updateFluxoTago(){

  $funcaoTrataToTAgo = "const topico = msg.topic\nconst carga = msg.payload\nvar fim_sub_topico = topico.indexOf(\"/\" , 9); \nvar semi_topico = topico.substring(7, fim_sub_topico);\nvar pinDevice = topico.substring(fim_sub_topico + 1); \nconst tipoDevice = pinDevice.substring(0, 2);\n\nif (semi_topico == \"sinal\"){\n            const pinDeviceCorrigido = pinDevice + \"_dbm\";\n            const payload = {\n            \"variable\" : pinDeviceCorrigido,\n            \"unit\" : \"dBm\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n}else if (tipoDevice == \"01\"){\n    if (semi_topico == \"iluminacao\"){\n        if ((carga.substr(0, 1) == \"R\")){\n            return;\n        }\n            const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n    }else if (semi_topico == \"confirma\"){\n            const pinDeviceCorrigido = pinDevice + \"_Status\";\n            const payload = {\n            \"variable\" : pinDeviceCorrigido,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n    }else if (semi_topico == \"smartinterruptor\"){\n           const pinDeviceCorrigido = pinDevice + \"_Secao\";\n            const payload = {\n            \"variable\" : pinDeviceCorrigido,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n    }\n}else if (tipoDevice == \"02\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"%\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"03\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"°C\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"04\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"Lux\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"05\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"06\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"%\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"07\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"Psi\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"08\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"m\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"09\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"12\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"W\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"13\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"14\"){\n    if (semi_topico == \"switch\"){\n        if ((carga.substr(0, 1) == \"R\")){\n            return;\n        }\n            const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n    }else if (semi_topico == \"confirma\"){\n            const pinDeviceCorrigido = pinDevice + \"_Status\";\n            const payload = {\n            \"variable\" : pinDeviceCorrigido,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n    }else if (semi_topico == \"smartinterruptor\"){\n           const pinDeviceCorrigido = pinDevice + \"_Secao\";\n            const payload = {\n            \"variable\" : pinDeviceCorrigido,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n            msg.payload = payload;\n            return msg;\n    }\n}else if (tipoDevice == \"15\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"16\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"17\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"18\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"19\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"20\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"21\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"22\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"°C\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"24\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"°C\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}else if (tipoDevice == \"03\"){\n    \n    const payload = {\n            \"variable\" : pinDevice,\n            \"unit\" : \"°C\",\n            \"value\" : carga\n            };\n\n   msg.payload = payload;\n   return msg;\n}\n";
  $access_token = Get_BearerToken_NoreRed_tago();
  $flows = getFluxoTagoIO();
  $id = $flows->id;
  $label = $flows->label;
  $info = $flows->info;
  $nodes = $flows->nodes;

  
   $ArrayNodes = array(
    );

   // array_push($ArrayNodes, $modelTratarTopico2);

    

    $apikey_gh = Get_Token_tago();
    while($rec = mysqli_fetch_array($apikey_gh)) 
		{
      $passwordMqttToga = $rec['apikey_gh'];
    }
   // echo "Password :" . $passwordMqttToga;



    $NodeMqttEntrada = array(
      'id' => '323d5f07.5196c', 
      'type' => 'mqtt in', 
      'z' => '827f49e3.691098',
      'name' => 'Mqtt Entrada',
      'topic' => '/house/#',
      'qos' => '2',
      'datatype' => 'auto',
      'broker' => '8b47545.6bac3a8',
      'x' => 170,
      'y' => 160,
      'wires' => array(
              array(
                "fb858c3.bfaae7", 
                )
                )
      );

      array_push($ArrayNodes, $NodeMqttEntrada);

      $TratarGoogleHome = array(
        'id' => 'fb858c3.bfaae7', 
        'type' => 'function', 
        'z' => '827f49e3.691098',
        'name' => 'Tratar_Topicos_To_Tago',
        'func' => $funcaoTrataToTAgo,
        'outputs' => 1,
        'noerr' => 0,
        'x' => 430,
        'y' => 160,
        'wires' => array(
                array(
                  "5ce28102.98702", 
                  )
            )
        );
    
        array_push($ArrayNodes, $TratarGoogleHome);


    $NodeMqttSaida = array(
      'id' => '5ce28102.98702', 
      'type' => 'mqtt out', 
      'z' => '827f49e3.691098',
      'name' => 'Tago',
      'topic' => 'tago/data/post',
      'qos' => '',
      'retain' => '',
      'broker' => 'ed9e6cbc.e10e7',
      'x' => 650,
      'y' => 160,
      'wires' => array()
      );

      array_push($ArrayNodes, $NodeMqttSaida);

      $NodeMqttBroker = array(
        'id' => 'ed9e6cbc.e10e7', 
        'type' => 'mqtt-broker', 
        'z' => '',
        'name' => 'Tago',
        'broker' => 'mqtt.tago.io',
        'port' => '1883',
        'clientid' => '',
        'usetls' => false,
        'compatmode' => true,
        'keepalive' => "60",
        'cleansession' => true,
        'birthTopic' => '',
        'birthQos' => '0',
        'birthPayload' => '',
        'closeTopic' => '',
        'closeQos' => '0',
        'closePayload' => '',
        'willTopic' => '',
        'willQos' => '0',
        'willPayload' => '',
        'credentials' => array (
          'user' => 'AutoDomoLais',
          'password' => $passwordMqttToga
          )
        );
  
        array_push($ArrayNodes, $NodeMqttBroker);

   $arrayGeral = array(
    'id' => $id, 
    'label' => $label, 
    'info' => $info,
    'nodes' => $ArrayNodes

  );

  $data = json_encode($arrayGeral);

  //echo $data;

  $endereco = $_SERVER[HTTP_HOST];

  $idfluxo = '827f49e3.691098';
  $url = "http://{$endereco}:1880/flow/{$idfluxo}";

  // use key 'http' even if you send the request to https://...
	$options = array(
    'http' => array(
        'header' => 'Authorization: Bearer '. $access_token  . "\r\n"  . 
        "Content-Type: application/json\r\n",
        'method'  => 'PUT',
        'content' => $data
    	)
	);
    $context  = stream_context_create($options);
	 $result = file_get_contents($url, false, $context);
   //$Jsonresult = json_decode($result);
	 return  json_decode($result);


}

//$saida = updateFluxoTago();

?>