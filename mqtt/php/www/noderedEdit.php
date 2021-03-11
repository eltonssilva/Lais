<?php
require_once("usuario/dados_bd.php");
error_reporting(0);


function Get_Token()
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


function Get_Devices()
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		
		$query = "SELECT widget.*, ambiente.Descricao nomeambiente FROM `widget`, ambiente  where dispositivo_fisico = 1 AND ambiente.id = widget.ambiente AND dispositivo_fisico = '1'";
		
		mysqli_set_charset($cnx, 'utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		
		// while($rec = mysqli_fetch_array($data)) 
		// {
		// 	$token = $rec['bearertoken'];
		// }

		return $data;
}


function Get_BearerToken_NoreRed()
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

function getFluxo(){
  $access_token = Get_BearerToken_NoreRed();

  $endereco = $_SERVER[HTTP_HOST];

  $url = "http://{$endereco}:1880/flow/1a12526.c8edbae";

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

function updateFluxo(){
  $access_token = Get_BearerToken_NoreRed();
  $flows = getFluxo();
  $id = $flows->id;
  $label = $flows->label;
  $info = $flows->info;
  $nodes = $flows->nodes;



  




    $modelTratarTopico = array(
      'id' => '5274d5d3.688b5c', 
      'type' => 'function', 
      'z' => '1a12526.c8edbae',
      'name' => 'Tratar Topico',
      'func' => "if(msg.topic == \"/house/persiana/09AAFABE68E3\"){\n    return msg;\n}",
      'outputs' => 1,
      'noerr' => 0,
      'x' => 700,
      'y' => 200,
      'wires' => array(
              array(
                "6df42d18.d5f3f4"
                )
                )
      );



  
    $ArrayNodes = array(
    );

   // array_push($ArrayNodes, $modelTratarTopico2);

    
  
//****************************************************************************** */
    // Criando Objeto Tratar Topicos
//****************************************************************************** */

     $device =  Get_Devices();
     $_x = 700;
     $_y = 50;
     $wiresTratarGoogleHome = array();

   		while($rec = mysqli_fetch_array($device)) 
		{
      $_id = $rec['id'];
      $_setPubTopic0 = $rec['setPubTopic0'];
      $_username_iphone = str_replace(":", "", $rec['username_iphone']);
      $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
      $_tipo_geral = $rec['tipo_geral'];

      if (($_tipo_geral == "1") || 
      ($_tipo_geral == "14") || 
      ($_tipo_geral == "15") ||
      ($_tipo_geral == "5") || 
      ($_tipo_geral == "9") ||
      ($_tipo_geral == "20") ||
      ($_tipo_geral == "24") ||
      ($_tipo_geral == "17"))
      {

            $_y = $_y + 50;

            $_primeiraparteId = substr($_username_iphone, 4);
            $_segundaparteId = substr($_pin_iphone, 2);
            $_segundaparteIdWire = substr($_pin_iphone, 3) . 'a';

            $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
            $_idCompletoWire = strtolower($_primeiraparteId . "." . $_segundaparteIdWire);

            $modelTratarTopico = array(
              'id' => $_idCompleto, 
              'type' => 'function', 
              'z' => '1a12526.c8edbae',
              'name' => 'Tratar Topico'. $_id,
              'func' => "if(msg.topic == \"" . $_setPubTopic0 .   "\"){\n    return msg;\n}",
              'outputs' => 1,
              'noerr' => 0,
              'x' => $_x,
              'y' => $_y,
              'wires' => array(
                      array(
                        $_idCompletoWire
                        )
                        )
              );

        
                array_push($ArrayNodes, $modelTratarTopico);
                array_push($wiresTratarGoogleHome, $_idCompleto);
        }

        
    }
    
//****************************************************************************** */
    // Criando Objeto Noras de Lampadas (Onoff em Geral) 
//****************************************************************************** */

    $device =  Get_Devices();
    $_x = 1000;
    $_xb = 1300;
    $_xc = 1600;
    $_xd = 1900;
    $_xe = 2200;
    $_y = 50;

    while($rec = mysqli_fetch_array($device)) 
		{
      $_tipo_geral = $rec['tipo_geral'];

      if (($_tipo_geral == "14") || ($_tipo_geral == "15"))
    {
      $_y = $_y + 50;
      $_id = $rec['id'];
      $_setPubTopic0 = $rec['setPubTopic0'];
      $type_kappelt = $rec['type_kappelt'];
      $_username_iphone = str_replace(":", "", $rec['username_iphone']);
      $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
      $_Descricao= str_replace("-", "", $rec['Descricao']);
      $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);

      $_primeiraparteId = substr($_username_iphone, 4);
      $_segundaparteId = substr($_pin_iphone, 3) . 'a';
      $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);

       if ($type_kappelt == "Outlet"){
        $_type = "nora-switch";  //nora-switch
        }else{
        $_type = "nora-light";  //nora-switch
        }
           

      $modelTratarTopico = array(
        'id' => $_idCompleto, 
        'type' => $_type, 
        'z' => '1a12526.c8edbae',
        "devicename" => $_Descricao,
        "roomhint" => $_nomeambiente,
        'name' => $_Descricao,

        "lightcolor" => false,
        "brightnesscontrol" => false,
        "turnonwhenbrightnesschanges" => false,
        "statepayload"=> true,
        "brightnessoverride" => "",
        
        'passthru' => false,
        "nora" => "d3c8442d.b94d08",
        "topic" => $_setPubTopic0,
        "onvalue" => "1",
        "onvalueType" => "str",
        "offvalue" => "0",
        "offvalueType" => "str",
        'x' => $_x,
        'y' => $_y,
        'wires' => array(
                array(
                  "e7e77ad0.97d118"
                  )
                )
        );

    array_push($ArrayNodes, $modelTratarTopico);

    }else if ($_tipo_geral == "1"){
      $_y = $_y + 50;
      $_id = $rec['id'];
      $_setPubTopic0 = $rec['setPubTopic0'];
      $type_kappelt = $rec['type_kappelt'];
      $_username_iphone = str_replace(":", "", $rec['username_iphone']);
      $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
      $_Descricao= str_replace("-", "", $rec['Descricao']);
      $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);

      $_primeiraparteId = substr($_username_iphone, 4);
      $_segundaparteId = substr($_pin_iphone, 3) . 'a';
      $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);

      if ($type_kappelt == "Outlet"){
        $_type = "nora-switch";  //nora-switch
        }else{
        $_type = "nora-light";  //nora-switch
        }

      $modelTratarTopico = array(
        'id' => $_idCompleto, 
        'type' => $_type, 
        'z' => '1a12526.c8edbae',
        "devicename" => $_Descricao,

        "lightcolor" => false,
        "brightnesscontrol" => false,
        "turnonwhenbrightnesschanges" => false,
        "statepayload"=> true,
        "brightnessoverride" => "",

        "roomhint" => $_nomeambiente,
        'name' => $_Descricao,
        'passthru' => false,  
        "nora" => "d3c8442d.b94d08",
        "topic" => $_setPubTopic0,
        "onvalue" => "1",
        "onvalueType" => "str",
        "offvalue" => "0",
        "offvalueType" => "str",
        'x' => $_x,
        'y' => $_y,
        'wires' => array(
                array(
                  "e7e77ad0.97d118"
                  )
                )
        );

        array_push($ArrayNodes, $modelTratarTopico);

      }else if ($_tipo_geral == "5"){
        $_y = $_y + 50;
        $_id = $rec['id'];
        $_setPubTopic0 = $rec['setPubTopic0'];
        $_username_iphone = str_replace(":", "", $rec['username_iphone']);
        $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
        $_Descricao= str_replace("-", "", $rec['Descricao']);
        $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);
  
        $_primeiraparteId = substr($_username_iphone, 4);
        $_segundaparteId = substr($_pin_iphone, 3) . 'a';
        $_terceiraparteIdb = substr($_pin_iphone, 3) . 'b';
        $_terceiraparteIdc = substr($_pin_iphone, 3) . 'c';
        $_terceiraparteIdd = substr($_pin_iphone, 3) . 'd';

        $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
        $_idCompletoTerceiraB = strtolower($_primeiraparteId . "." . $_terceiraparteIdb);
        $_idCompletoTerceiraC = strtolower($_primeiraparteId . "." . $_terceiraparteIdc);
        $_idCompletoTerceiraD= strtolower($_primeiraparteId . "." . $_terceiraparteIdd);

        $modelTratarTopico = array(
          'id' => $_idCompleto, 
          'type' => 'nora-light', 
          'z' => '1a12526.c8edbae',
          "devicename" => $_Descricao,
          "lightcolor" => true,
          "brightnesscontrol" => true,
          "turnonwhenbrightnesschanges" => true,
          "roomhint" => $_nomeambiente,
          'name' => $_Descricao,
          'passthru' => false,
          "statepayload"=> true,
          "brightnessoverride" => "",
          "nora" => "d3c8442d.b94d08",
          "topic" => $_setPubTopic0,
          "onvalue" => "1",
          "onvalueType" => "str",
          "offvalue" => "0",
          "offvalueType" => "str",
          'x' => $_x,
          'y' => $_y,
          'wires' => array(
                  array(
                    $_idCompletoTerceiraB
                    )
                  )
          );

          $modelTratarRGB1 = array(
            'id' => $_idCompletoTerceiraB, 
            'type' => 'function', 
            'z' => '1a12526.c8edbae',
            'name' => 'Tratar RGB 1_'. $_id,
            "func"=> "\n//var valorzigbee_json =  JSON.parse(msg.payload);\nvar valorzigbee_json =  msg.payload;\n//carga = \"00\"  + valorzigbee_json.openPercent.toString();\n\nconst ligado = valorzigbee_json.on;\n\nif (ligado)\n    {\n    \n        const cor = {\n            \n        \"brightness\" : valorzigbee_json.brightness,\n        \"hue\" : valorzigbee_json.color.spectrumHsv.hue,\n        \"saturation\" : valorzigbee_json.color.spectrumHsv.saturation,\n         \"value\" : valorzigbee_json.color.spectrumHsv.value\n        }\n        \n        msg.payload =  cor;\n        return msg;\n\n    }\n    \nelse\n    {\n    \n    const cor = { \n    \"brightness\" : 0,\n    \"hue\" : 0,\n    \"saturation\" : 0,\n    \"value\" : 0\n    }\n    \n    msg.payload =  cor;\n    return msg;\n\n}\n\n\n\n",
            'outputs' => 1,
            'noerr' => 0,
            'x' => $_xb,
            'y' => $_y,
            'wires' => array(
                    array(
                      $_idCompletoTerceiraC,
                      )
                      )
            );

            $modelTratarRGB_Convert = array(
              "id"=> $_idCompletoTerceiraC,
              "type"=> "color-convert",
              "z"=> "1a12526.c8edbae",
              "input"=> "hsv",
              "output"=> "rgb",
              "outputType"=> "object",
              "scaleInput"=> true,
              'x' => $_xc,
              'y' => $_y,
              'wires' => array(
                array(
                  $_idCompletoTerceiraD
                  )
                  )

            );

            $modelTratarRGB2 = array(
              'id' => $_idCompletoTerceiraD, 
              'type' => 'function', 
              'z' => '1a12526.c8edbae',
              'name' => 'Tratar RGB 2_'. $_id,
              "func"=> "\n//var valorzigbee_json =  JSON.parse(msg.payload);\nvar corJson =  msg.payload;\n//carga = \"00\"  + valorzigbee_json.openPercent.toString();\nlet red = \"000\" + corJson.red;\nlet green = \"000\" + corJson.green;\nlet blue = \"000\" + corJson.blue;\n\nlet redCorrigido = red.substr(-3);\nlet greenCorrigido = green.substr(-3);\nlet blueCorrigido = blue.substr(-3);\n\nconst mensagem = \"r\" + redCorrigido + \",\" +  greenCorrigido + \",\" + blueCorrigido + \"#\";\n\n\nmsg.payload =  mensagem;\nreturn msg;\n",
              'outputs' => 1,
              'noerr' => 0,
              'x' => $_xd,
              'y' => $_y,
              'wires' => array(
                      array(
                        "e7e77ad0.97d118"
                        )
                        )
              );



  
          array_push($ArrayNodes, $modelTratarTopico);
          array_push($ArrayNodes, $modelTratarRGB1);
          array_push($ArrayNodes, $modelTratarRGB_Convert);
          array_push($ArrayNodes, $modelTratarRGB2);

      } else if ($_tipo_geral == "9")
      {
        $_y = $_y + 50;
        $_id = $rec['id'];
        $_setPubTopic0 = $rec['setPubTopic0'];
        $_username_iphone = str_replace(":", "", $rec['username_iphone']);
        $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
        $_Descricao= str_replace("-", "", $rec['Descricao']);
        $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);
  
        $_primeiraparteId = substr($_username_iphone, 4);
        $_segundaparteId = substr($_pin_iphone, 3) .  'a';
        $_terceiraparteId = substr($_pin_iphone, 3) . 'b';
        $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
        $_idCompletoTerceira = strtolower($_primeiraparteId . "." . $_terceiraparteId);
        $modelTratarTopico = array(
          'id' => $_idCompleto, 
          'type' => 'nora-blinds', 
          'z' => '1a12526.c8edbae',
          "devicename" => $_Descricao,
          "roomhint" => $_nomeambiente,
          'name' => $_Descricao,
          'passthru' => false,
          "invert"=> false,
          "nora" => "d3c8442d.b94d08",
          "topic" => $_setPubTopic0,
          "onvalue" => "1",
          "onvalueType" => "str",
          "offvalue" => "0",
          "offvalueType" => "str",
          'x' => $_x,
          'y' => $_y,
          'wires' => array(
                  array(
                    $_idCompletoTerceira
                    )
                  )
          );
  
          

          $modelTratarPersiana = array(
            'id' => $_idCompletoTerceira, 
            'type' => 'function', 
            'z' => '1a12526.c8edbae',
            'name' => 'Tratar Persiana'. $_id,
            "func"=> "\n//var valorzigbee_json =  JSON.parse(msg.payload);\nvar valorzigbee_json =  msg.payload;\ncarga = \"00\"  + valorzigbee_json.openPercent.toString();\nmsg.payload =  \"P\" + carga.substr(-3);\nreturn msg;\n",
            'outputs' => 1,
            'noerr' => 0,
            'x' => $_xb,
            'y' => $_y,
            'wires' => array(
                    array(
                      "e7e77ad0.97d118"
                      )
                      )
            );

      array_push($ArrayNodes, $modelTratarTopico);
      array_push($ArrayNodes, $modelTratarPersiana);



  
      } else if ($_tipo_geral == "20")
      {
        $_y = $_y + 50;
        $_id = $rec['id'];
        $_setPubTopic0 = $rec['setPubTopic0'];
        $_username_iphone = str_replace(":", "", $rec['username_iphone']);
        $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
        $_Descricao= str_replace("-", "", $rec['Descricao']);
        $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);
        $_primeiraparteId = substr($_username_iphone, 4);
        $_segundaparteId = substr($_pin_iphone, 3) . 'a';
        $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
        $modelTratarTopico = array(
          'id' => $_idCompleto, 
          'type' => 'nora-garage', 
          'z' => '1a12526.c8edbae',
          "devicename" => $_Descricao,
          "roomhint" => $_nomeambiente,
          'name' => $_Descricao,
          'passthru' => false,
          "nora" => "d3c8442d.b94d08",
          "topic" => $_setPubTopic0,
          "openvalue"=> "P100",
          "openvalueType" => "str",
          "closevalue"=> "P000",
          "closevalueType" => "str",
          'x' => $_x,
          'y' => $_y,
          'wires' => array(
                  array(
                    "e7e77ad0.97d118"
                    )
                  )
          );
  
      array_push($ArrayNodes, $modelTratarTopico);
  
      } else if ($_tipo_geral == "24"){
        $_y = $_y + 50;
        $_id = $rec['id'];
        $_setPubTopic0 = $rec['setPubTopic0'];
        $_username_iphone = str_replace(":", "", $rec['username_iphone']);
        $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
        $_Descricao= str_replace("-", "", $rec['Descricao']);
        $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);
  
        $_primeiraparteId = substr($_username_iphone, 4);
        $_segundaparteId = substr($_pin_iphone, 3) . 'a';
        $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
        $modelTratarTopico = array(
          'id' => $_idCompleto, 
          'type' => 'nora-light', 
          'z' => '1a12526.c8edbae',
          "devicename" => $_Descricao,
          "lightcolor" => false,
          "brightnesscontrol" => true,
          "turnonwhenbrightnesschanges" => true,
          "roomhint" => $_nomeambiente,
          'name' => $_Descricao,
          'passthru' => false,
          "statepayload"=> true,
          "brightnessoverride" => "",
          "nora" => "d3c8442d.b94d08",
          "topic" => $_setPubTopic0,
          "onvalue" => "1",
          "onvalueType" => "str",
          "offvalue" => "0",
          "offvalueType" => "str",
          'x' => $_x,
          'y' => $_y,
          'wires' => array(
                  array(
                    "e7e77ad0.97d118"
                    )
                  )
          );
  
          array_push($ArrayNodes, $modelTratarTopico);
      }else if ($_tipo_geral == "17"){
        $_y = $_y + 50;
        $_id = $rec['id'];
        $_setPubTopic0 = $rec['setPubTopic0'];
        $_username_iphone = str_replace(":", "", $rec['username_iphone']);
        $_pin_iphone = str_replace("-", "", $rec['pin_iphone']);
        $_Descricao= str_replace("-", "", $rec['Descricao']);
        $_nomeambiente= str_replace("-", "", $rec['nomeambiente']);
  
        $_primeiraparteId = substr($_username_iphone, 4);
        $_segundaparteId = substr($_pin_iphone, 3) . 'a';
        $_idCompleto = strtolower($_primeiraparteId . "." . $_segundaparteId);
        $modelTratarTopico = array(
          'id' => $_idCompleto, 
          'type' => 'nora-lock', 
          'z' => '1a12526.c8edbae',
          "devicename" => $_Descricao,
          "lightcolor" => false,
          "brightnesscontrol" => true,
          "turnonwhenbrightnesschanges" => true,
          "roomhint" => $_nomeambiente,
          'name' => $_Descricao,
          'passthru' => false,
          "statepayload"=> true,
          "brightnessoverride" => "",
          "nora" => "d3c8442d.b94d08",
          "topic" => $_setPubTopic0,
          "lockValue" => true,
          "lockValueType"=> "bool",
          "unlockValue" => false,
          "unlockValueType"=> "bool",
          "jammedValue"=> true,
          "jammedValueType"=> "bool",
          "unjammedValue"=> false,
          "unjammedValueType"=> "bool",
          'x' => $_x,
          'y' => $_y,
          'wires' => array(
                  array(
                    "e7e77ad0.97d118"
                    )
                  )
          );
  
          array_push($ArrayNodes, $modelTratarTopico);
      }
   
 


        
    }

    $bearertoken = Get_Token();
    while($rec = mysqli_fetch_array($bearertoken)) 
		{
      $tokenNora = $rec['bearertoken'];
    }

    $nodeNoraConfig = array(
      'id' => 'd3c8442d.b94d08',
      'type' => 'nora-config',
      'z' => '',
      'credentials' => array ('token' =>$tokenNora),
      'name' => 'AutoDomoToken',
      'group' => '',
      'notify' => false,
    );

    array_push($ArrayNodes, $nodeNoraConfig);

   $TratarGoogleHome = array(
    'id' => '885ddb14.2547f8', 
    'type' => 'function', 
    'z' => '1a12526.c8edbae',
    'name' => 'Tratar GoogleHome',
    'func' => "const topico = msg.topic\nconst carga = msg.payload\nvar fim_sub_topico = topico.indexOf(\"/\" , 9); \nvar semi_topico = topico.substring(7, fim_sub_topico);\nvar pinDevice = topico.substring(fim_sub_topico + 1); \nconst tipoDevice = pinDevice.substring(0, 2);\n\n\n\nif(semi_topico != \"confirma\"){\n    return;\n}\n\nelse if (tipoDevice == \"01\"){\n    \n    msg.topic = \"/house/iluminacao/\" + pinDevice;\n    \n    if(carga == \"On\" || carga == \"on\" || carga == \"1\"){\n        msg.payload = \"1\";\n    }else if (carga == \"Off\" || carga == \"off\" || carga == \"0\"){\n        msg.payload = \"0\";\n    }\n    \n    return msg;\n}\n\nelse if (tipoDevice == \"14\"){\n    \n    msg.topic = \"/house/switch/\" + pinDevice;\n    \n    if(carga == \"On\" || carga == \"on\" || carga == \"1\"){\n        msg.payload = \"1\";\n    }else if (carga == \"Off\" || carga == \"off\" || carga == \"0\"){\n        msg.payload = \"0\";\n    }\n    \n    return msg;\n}\n\nelse if (tipoDevice == \"09\"){\n    \n    const cargaCorrigida = {\"openPercent\": msg.payload}\n    msg.topic = \"/house/persiana/\" + pinDevice;\n    msg.payload  = cargaCorrigida\n    \n    return msg;\n}else if (tipoDevice == \"20\"){\n    \n    msg.topic = \"/house/garage/\" + pinDevice;\n\n    return msg;\n}\n\n\n\n",
    'outputs' => 1,
    'noerr' => 0,
    'x' => 370,
    'y' => ($_y - 50)/2 + 50,
    'wires' => array(
                  $wiresTratarGoogleHome
              )
    );

    array_push($ArrayNodes, $TratarGoogleHome);

    $NodeMqttEntrada = array(
      'id' => 'fdff8d15.86e92', 
      'type' => 'mqtt in', 
      'z' => '1a12526.c8edbae',
      'name' => 'Mqtt Entrada',
      'topic' => '/house/confirma/#',
      'qos' => '2',
      'datatype' => 'auto',
      'broker' => '8b47545.6bac3a8',
      'x' => 130,
      'y' => ($_y - 50)/2 + 50,
      'wires' => array(
              array(
                "885ddb14.2547f8", 
                )
                )
      );

      array_push($ArrayNodes, $NodeMqttEntrada);

    $NodeMqttSaida = array(
      'id' => 'e7e77ad0.97d118', 
      'type' => 'mqtt out', 
      'z' => '1a12526.c8edbae',
      'name' => 'Mqtt Saida 2',
      'topic' => '',
      'qos' => '',
      'retain' => '',
      'broker' => '8b47545.6bac3a8',
      'x' => $_xe,
      'y' => ($_y - 50)/2 + 50,
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

  //echo $data;

  $endereco = $_SERVER[HTTP_HOST];

  $url = "http://{$endereco}:1880/flow/1a12526.c8edbae";

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

//$saida = updateFluxo();

?>