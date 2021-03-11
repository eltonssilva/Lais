<?php
require_once("usuario/dados_bd.php");
error_reporting(0);


function Get_TokenCameras()
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		
		$query = "SELECT bearertoken FROM `servidor`";
		
		mysqli_set_charset($cnx, 'utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);

		return $data;
}


function Get_Devices_Movimento()
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		
		$query = "SELECT widget.*, ambiente.Descricao nomeambiente FROM `widget`, ambiente where dispositivo_fisico = 1 AND ambiente.id = widget.ambiente AND type_kappelt = 'hikvision' AND tipo_geral = '13'";
		
		mysqli_set_charset($cnx, 'utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		
		return $data;
}


function Get_BearerToken_NoreRed_Cameras()
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

function getFluxocameras(){
  $access_token = Get_BearerToken_NoreRed_Cameras();

  $endereco = $_SERVER[HTTP_HOST];
  $idfluxo = '21b80430.90483c';

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

function updateFluxoCameras(){
  $idfluxo = '21b80430.90483c';
  $_idWireSaidaGeral = 'c4652b80.83e628';
  $access_token = Get_BearerToken_NoreRed_Cameras();
  $flows = getFluxocameras();
  $id = $flows->id;
  $label = $flows->label;
  $info = $flows->info;
  $nodes = $flows->nodes;

  //  $label = 'ttt';
  //  $info = 'info';
   $nodes = $flows->nodes;


  $ArrayNodes = array();




  $device =  Get_Devices_Movimento();
  $_x = 300;
  $_y = 50;
  $NodeHikVision = array();

  while($rec = mysqli_fetch_array($device)) 
  {
    $_id = $rec['id'];
    $_setPubTopic0 = $rec['setPubTopic0'];
    $_username_iphone = str_replace(":", "", $rec['username_iphone']);
    $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
    $_tipo_geral = $rec['tipo_geral'];
    $_ip_camera = $rec['traits_type_kappelt'];
    $user = $rec['label'];
    $password = $rec['label2'];

    $_y = $_y + 100;

    $_primeiraparteId = substr($_username_iphone, 4);
    $_segundaparteId = substr($_pin_iphone, 2);
    $_segundaparteIdWire_a = substr($_pin_iphone, 3) . 'a';
    $_segundaparteIdWire_b = substr($_pin_iphone, 3) . 'b';
    $_segundaparteIdWire_c = substr($_pin_iphone, 3) . 'c';
    $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
    $_idCompletoWireSaida = strtolower($_primeiraparteId . "." . $_segundaparteIdWire_a);
    $_idCompletoWireErro  = strtolower($_primeiraparteId . "." . $_segundaparteIdWire_b);
    $_idCompletoConfig = strtolower($_primeiraparteId . "." . $_segundaparteIdWire_c);

    $modelCamera = array(
      'id' => $_idCompleto, 
      'type' => 'hikvisionUltimateAlarm', 
      'z' => $idfluxo,
      'name' => 'Camera-'. $_username_iphone,
      "topic"=> "alarme",
      "server"=> $_idCompletoConfig,
      "reactto"=> "vmd",
      'x' => $_x,
      'y' => $_y,
      'wires' => array(
              array(
                $_idCompletoWireSaida
              ),
                array(
                  $_idCompletoWireErro
                  )
                )
      );

      $modelCameraConfig = array(
        "id"=> $_idCompletoConfig,
        "type"=> "Hikvision-config",
        "z"=> "",
        "host"=> $_ip_camera,
        "port"=> "80",
        "name"=> 'CameraConfig-'. $_username_iphone,
        "authentication"=> "digest",
        "protocol"=> "http",
        "heartbeattimerdisconnectionlimit"=> "2",
        "credentials" =>  array(
           "user" => $user,
           "password" => $password
         )
        );

      $modelSaidaOk = array(
        'id' => $_idCompletoWireSaida, 
        'type' => 'function', 
        'z' => $idfluxo,
        'name' => 'Correção_Saida_OK'. $_id,
        'func' => "let saida = \"0\";\nif (msg.payload){\n    saida = \"1\";\n \n}\nmsg.topic = \"/house/motion/13AA00000029\";\nmsg.payload = saida;\n\nreturn msg;",
        'outputs' => 1,
        'noerr' => 0,
        'x' => $_x + 300,
        'y' => $_y - 20,
        'wires' => array(
                array(
                  $_idWireSaidaGeral
                  )
                  )
        );

        $modelSaidaErro = array(
          'id' => $_idCompletoWireErro, 
          'type' => 'function', 
          'z' => $idfluxo,
          'name' => 'Correção_Saida_Erro'. $_id,
          'func' => "let saida = \"0\";\nif (msg.payload){\n    saida = \"1\";\n \n}\nmsg.topic = \"/house/motion/13AB00000029\";\nmsg.payload = saida;\n\nreturn msg;",
          'outputs' => 1,
          'noerr' => 0,
          'x' => $_x + 300,
          'y' => $_y + 20,
          'wires' => array(
                  array(
                    $_idWireSaidaGeral
                    )
                    )
          );


      array_push($ArrayNodes, $modelCamera);
      array_push($ArrayNodes, $modelSaidaOk);
      array_push($ArrayNodes, $modelSaidaErro);
      array_push($ArrayNodes, $modelCameraConfig);
      
  
  }

  $NodeMqttSaida = array(
    'id' => $_idWireSaidaGeral, 
    'type' => 'mqtt out', 
    'z' => $idfluxo,
    'name' => 'Mqtt Saida Cameras',
    'topic' => '',
    'qos' => '',
    'retain' => '',
    'broker' => '8b47545.6bac3a8',
    'x' =>$_x + 600,
    'y' => (($_y + 100) - 50)/2 + 50,
    'wires' => array()
    );

    array_push($ArrayNodes, $NodeMqttSaida);

  $arrayGeral = array(
      'id' => $id, 
      'label' => $label, 
      'info' => $info,
      'nodes' => $ArrayNodes
    );
    
  $data = json_encode($arrayGeral);
  
 // echo   $data;

  

  $endereco = $_SERVER[HTTP_HOST];

  $url = "http://{$endereco}:1880/flow/{$idfluxo}";

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
   return  json_decode($result);
  

    

}

//$saida = updateFluxoCameras();

?>