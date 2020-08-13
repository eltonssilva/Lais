<?php
require_once("usuario/dados_bd.php");
error_reporting(0);


//$id = isset($_GET['id']) ? $_GET['id'] : "0";

//$bearertoken = Get_BearerToken_FromKapellt();
//$bearertoken = Get_BearerToken_FromDB();
//$result = GetAllDeviceInfor($bearertoken);
//$result = GetDeviceSpecificInfor($bearertoken, 7254);
//$result = DeleteDeviceSpecific($bearertoken, 7249);
//$result =   UpdateDevice($bearertoken, 7252, "Lâmpada Aguiar 7252", "Light", "OnOff", true, true,  "iluminacao/01AA00000023",   "confirma/01AA00000023");
//$result = GetUserSpecificInfor($bearertoken, 1773, "c4ca4238a0b92387", "autodomum@autodomum.com.br", "gbridge-u1773");
//$result = newDeviceKapellt($bearertoken, "Lampada Fora", "Light", "OnOff", true, true,  "iluminacao/01AA00000012",   "confirma/01AA00000012");
//SaveDates($result, 2, 1);  // Salva Bearer Tokem
//echo $result;

function Get_BearerToken_FromDB()
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
		$APYKEY="";
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		
		$query = "SELECT * FROM `servidor` WHERE id='1'";
		
		mysqli_set_charset('utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		
		while($rec = mysqli_fetch_array($data)) 
		{
			$token = $rec['bearertoken'];
		}

		return $token;
}




function Get_BearerToken_FromKapellt()
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
		$APYKEY="";
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		
		$query = "SELECT * FROM `servidor` WHERE id='1'";
		
		mysqli_set_charset($cnx, 'utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		
		while($rec = mysqli_fetch_array($data)) 
{
		$APYKEY = $rec['apikey_gh'];
}

//echo $APYKEY;
		
//$APYKEY = 'QyJmXq3XmgnJABkg:U0oxdWhwS092QVFtV3NCazhkc2gxd1lCVGo3dWVyR002aUFnRHlDUTY0VjJVYkh5YWtKUXYxNVVuUnEwdGh6MktaRVVRaHFLUmNLS21PQ2pTOWRpWlFxNWtKSUtpRExZQVlWNGYxb3p6c1RVTXFCR3FzVFI5aTlUWDNUWjl6eDk=';
$url = 'https://homegbridge.com/api/v2/auth/token';
$data = array('apikey' => $APYKEY);
// use key 'http' even if you send the request to https://...
	$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    	)
	);
    $context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$Jsonresult = json_decode($result);
	return  $Jsonresult->{'access_token'};
//	if ($result === FALSE) { echo "Erro"; }
}


function SaveDates($result, $tipo, $device_id_autodomum)
{
	// Tipo 0 - Limpa Todos os device_id_kappelt (Zera) do Banco de dados
	// Tipo 1 - Save Token
	// Tipo 2 - Save Date Device
	
		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		global $id;
		
		if ($tipo == 0)
		{
				$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
				$query = "UPDATE `widget` SET `device_id_kappelt` = '0' WHERE 1=1;";
					if(mysqli_query($cnx, $query)) 
					{
					//	header("location:sincronizargooglehome.php?id={$id}");
					} 
					else 
					{
						echo "Erro!";
					}

					mysqli_close($cnx);
	
		}
		if ($tipo == 1)
		{
			if (trim($result) != "")
				{
					$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
				$query = "UPDATE `servidor` SET `bearertoken` = '{$result}' WHERE `servidor`.`id` = 1;";
					if(mysqli_query($cnx, $query)) 
					{
					//	header("location:sincronizargooglehome.php?id={$id}");
					} 
					else 
					{
						echo "Erro!";
					}

					mysqli_close($cnx);
				}
			else
				{
				//	header("location:sincronizargooglehome.php?id={$id}");
				}
		}
		if ($tipo == 2)
		{
		$Jsonresult = json_decode($result, true);
		$device_id = $Jsonresult[id];
		$type_kappelt = $Jsonresult[type];
		$traits_type_kappelt = $Jsonresult[traits][0][type];
	//	echo "device_id=" . $device_id . "<br>";
		
			if (trim($result) != "")
				{
					$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
				$query = "UPDATE `widget` SET 
				`device_id_kappelt` = '$device_id'
				WHERE `widget`.`id` = {$device_id_autodomum};";
					if(mysqli_query($cnx, $query)) 
					{
					//	header("location:sincronizargooglehome.php?id={$id}");
					} 
					else 
					{
						echo "Erro!";
					}

					mysqli_close($cnx);
				}
			else
				{
				//	header("location:sincronizargooglehome.php?id={$id}");
				}
				return $device_id;
		}			
}

function GetAllDeviceInfor($BearerToken)
{
$url = "https://homegbridge.com/api/v2/device";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'GET'
    	)
	);
    $context  = stream_context_create($options);
	//echo json_encode($data) . "<br>";
	return $result = file_get_contents($url, false, $context);
}

function newDeviceKapellt($BearerToken, $name, $type, $traits_type, $traits_requiresActionTopic, $traits_requiresStatusTopic,  $traits_actionTopi,   $traits_statusTopic)
{
	
$array_traits_type = explode('-', $traits_type);

$_Str_Type = "";
$max = sizeof($array_traits_type);
foreach($array_traits_type as $_traits_type)
{
	
	$_Str_Type   .=   "{
						\"type\":\"{$_traits_type}\",
						\"requiresActionTopic\": $traits_requiresActionTopic,
						\"requiresStatusTopic\": $traits_requiresStatusTopic,
						\"actionTopic\": \"{$traits_actionTopi}\",
						\"statusTopic\": \"{$traits_statusTopic}\"
						}";
	$max--;
	if ($max > 0)
	{
		$_Str_Type .= ",";
	}
}

$data ="{
		\"name\": \"{$name}\",
		\"type\": \"{$type}\",
		\"traits\": 
			[" .
			 $_Str_Type
			. "],
		\"twofa\": \"\",
		\"twofaPin\": \"string\"
	}";
	
	$url = "https://homegbridge.com/api/v2/device";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'POST',
		'content' => $data
    	)
	);
    $context  = stream_context_create($options);
//	echo $data . "<br>";
	$result = file_get_contents($url, false, $context);
	SyncDevicesGoogleHome($BearerToken);
	return $result;

}

function GetDeviceSpecificInfor($BearerToken, $device_id)
{
$url = "https://homegbridge.com/api/v2/device/{$device_id}";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'GET'
    	)
	);
    $context  = stream_context_create($options);
	//echo json_encode($data) . "<br>";
	return $result = file_get_contents($url, false, $context);
}


function UpdateDevice($BearerToken, $device_id, $name, $type, $traits_type, $traits_requiresActionTopic, $traits_requiresStatusTopic,  $traits_actionTopi,   $traits_statusTopic)
{

	
$array_traits_type = explode('-', $traits_type);

$_Str_Type = "";
$max = sizeof($array_traits_type);
foreach($array_traits_type as $_traits_type)
{
	
	$_Str_Type   .=   "{
						\"type\":\"{$_traits_type}\",
						\"requiresActionTopic\": $traits_requiresActionTopic,
						\"requiresStatusTopic\": $traits_requiresStatusTopic,
						\"actionTopic\": \"{$traits_actionTopi}\",
						\"statusTopic\": \"{$traits_statusTopic}\"
						}";
	$max--;
	if ($max > 0)
	{
		$_Str_Type .= ",";
	}
}

$data ="{
		\"name\": \"{$name}\",
		\"type\": \"{$type}\",
		\"traits\": 
			[" .
			 $_Str_Type
			. "],
		\"twofa\": \"\",
		\"twofaPin\": \"string\"
	}";
	
	$url = "https://homegbridge.com/api/v2/device/{$device_id}";
//	echo $url . "<br>";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'PATCH',
		'content' => $data
    	)
	);
    $context  = stream_context_create($options);
	//echo $data . "<br>";
	$result = file_get_contents($url, false, $context);
	SyncDevicesGoogleHome($BearerToken);
	return $result;

}


function DeleteDeviceSpecific($BearerToken, $device_id)
{
$url = "https://homegbridge.com/api/v2/device/{$device_id}";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'DELETE'
    	)
	);
    $context  = stream_context_create($options);
	//echo json_encode($data) . "<br>";
	$result = file_get_contents($url, false, $context);
	$status_line = $http_response_header[0];
		preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
		SyncDevicesGoogleHome($BearerToken);
    return $status = $match[1];
}

function GetUserSpecificInfor($BearerToken, $userId, $displayName, $email, $mqttUsername)
{
	$data = array
	(
	'userId' => $userId, 
	'displayName' => $displayName,
	'email' => $email,
	'mqttUsername' => $mqttUsername
	);
			
$url = "https://homegbridge.com/api/v2/user";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'GET',
		'content' => $data
    	)
	);
    $context  = stream_context_create($options);
	//echo json_encode($data) . "<br>";
	return $result = file_get_contents($url, false, $context);
}


function DeleteAllDevices($BearerToken)
{
 $AllDevices = json_decode(GetAllDeviceInfor($BearerToken), true);
 $i = 0;	 
 foreach($AllDevices as $Device) 
	{ 
    $device_id = $Device['device_id'];
	DeleteDeviceSpecific($BearerToken, $device_id);
	$i++;
	}
	SyncDevicesGoogleHome($BearerToken);
	return $i;
}

function SyncDevicesGoogleHome($BearerToken)
{
$url = "https://homegbridge.com/api/v2/requestsync";
	$options = array(
    'http' => array(
      //  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'header' => 'Authorization: Bearer '. $BearerToken  . "\r\n"  . 
		"Content-Type: application/json\r\n",
        'method'  => 'GET'
    	)
	);
    $context  = stream_context_create($options);
	//echo json_encode($data) . "<br>";
	$result = file_get_contents($url, false, $context);
	$status_line = $http_response_header[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    return $status = $match[1];
}
?>